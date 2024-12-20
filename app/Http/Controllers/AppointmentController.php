<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    public function clientIndex($hairdresser_id)
    {
        try {
            $user = auth()->user();

            if (auth()->user()->role == 'cliente') {

                //Consulta para obtener las citas del usuario actual en peluqueria dada.
                $userAppointments = Appointment::where('client_id', $user->id)->where('hairdresser_id', $hairdresser_id)->get();

                // Consulta para obtener todas las citas de otros clientes y que no tengan el estado 'cancelado'
                $otherAppointments = Appointment::where('client_id', '!=', $user->id)
                    ->where('hairdresser_id', $hairdresser_id)
                    ->where('status', '!=', 'cancelado')  // Excluimos las citas con estado 'cancelado'
                    ->get();


                //Función que se encarga de recuperar las citas del cliente en la peluqueria seleccionada por el cliente.
                $userEvents = $userAppointments
                    ->map(function ($appointment) {
                        //Asignación del color del evento según el estado de la cita.
                        $statusColor = $this->getStatusColor($appointment->status);
                        //Se retorna la información de la cita en un formato adecuado para FullCalendar.
                        return [
                            'appointment_id' => $appointment->id,
                            'title' => "Cliente: {$appointment->client->name} - Servicio: {$appointment->service->name}",
                            'client_name' => $appointment->client->name,
                            'start' => $appointment->start->toIso8601String(),
                            'end' => $appointment->end ? $appointment->end->toIso8601String() : null,
                            'color' => $statusColor,
                            'status' => $appointment->status,
                            'service_id' => $appointment->service_id,
                            'edit' => true,
                            'service_name' => $appointment->service->name,
                            'client_id' => $appointment->client_id,
                            'hairdresser_id' => $appointment->hairdresser_id,
                        ];
                    });

                $otherEvents = $otherAppointments->map(function ($appointment) {
                    $statusColor = '#4c65f3';
                    return [
                        'appointment_id' => $appointment->id,
                        'title' => "Cita de otro cliente",
                        'start' => $appointment->start->toIso8601String(),
                        'end' => $appointment->end ? $appointment->end->toIso8601String() : null,
                        'color' => $statusColor,
                        'status' => $appointment->status,
                        'service_id' => $appointment->service_id,
                        'edit' => false,
                        'service_name' => $appointment->service->name,
                        'client_id' => $appointment->client_id,
                        'hairdresser_id' => $appointment->hairdresser_id,
                    ];
                });

                //Se alguno de los dos arrays, esta vacio, solo manda uno de ellos.
                if ($userEvents->isEmpty()) {
                    $events = $otherEvents;
                } else if ($otherEvents->isEmpty()) {
                    $events = $userEvents;
                } else {
                    //Se combinan los dos arrays para poder mostrar todas las citas en el calendario.
                    $events = $userEvents->merge($otherEvents);
                }



                //Se retorna las citas en formato JSON.
                Log::info('Citas obtenidas correctamente ', $events->toArray());
                return response()->json($events);
            } else if (auth()->user()->role == 'propietario') {
                //Se obtienen todas las citas de la peluquería.
                $hairdresserAppointments = Appointment::where('hairdresser_id', $hairdresser_id)->get();
                //Se recorren las citas del peluquero.
                $events = $hairdresserAppointments->map(function ($appointment) {
                    //Se asigna el color del evento según el estado de la cita.
                    $statusColor = $this->getStatusColor($appointment->status);
                    //Se retorna la información de la cita en un formato adecuado para FullCalendar.
                    return [
                        'appointment_id' => $appointment->id,
                        'title' => "Cliente: " . ($appointment->client ? $appointment->client->name : $appointment->unregistered_client) . " - Servicio: {$appointment->service->name}",
                        'client_name' => $appointment->client ? $appointment->client->name : $appointment->unregistered_client,
                        'start' => $appointment->start->toIso8601String(),
                        'end' => $appointment->end ? $appointment->end->toIso8601String() : null,
                        'color' => $statusColor,
                        'status' => $appointment->status,
                        'service_id' => $appointment->service_id,
                        'edit' => true,
                        'service_name' => $appointment->service->name,
                        'client_id' => $appointment->client_id,
                        'hairdresser_id' => $appointment->hairdresser_id,
                    ];
                });

                Log::info('Citas obtenidas correctamente', $events->toArray());
                return response()->json($events);
            }

            //Capturamos las posibles excepciones y mandamo un JSON por si queremos mostrar información del error al cliente.
        } catch (\Exception $e) {
            Log::error('Error al obtener las citas del cliente', [
                'error_message' => $e->getMessage(),
                'error_stack' => $e->getTraceAsString(),
                'user_id' => auth()->user()->id,
                'hairdresser_id' => $hairdresser_id,
            ]);
            return response()->json(['error' => 'Ha ocurrido un error al procesar la solicitud'], 500);
        }
    }


    //Función que se encarga de crear una cita.
    public function storeAppointment(Request $request)
    {
        try {

            //Si el usuario es propietario se valida también el nombre del cliente.
            if (auth()->user()->role == 'propietario') {
                Log::info('Datos enviados en el Request:', $request->all());
                $request->validate([
                    'client' => 'string|max:255',
                ]);

                if ($request->unregistered_client) {
                    $request->validate([
                        'unregistered_client' => 'string|max:80',
                    ]);
                }
            }

            //Se validan los campos enviados
            $request->validate([
                'start' => 'required|date',
                'end' => 'required|date',
                'status' => 'required|in:pendiente,confirmado,cancelado',
                'service' => 'required|exists:services,id',
            ]);

            //Comprobamos que no exista una cita en ese horario. Si tienen el estatus de cancelado si se pueden asignar las citas ahi.
            $existingAppointment = Appointment::where('hairdresser_id', $request->hairdresser_id)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('start', [$request->start, $request->end])
                        ->orWhereBetween('end', [$request->start, $request->end])
                        ->orWhere(function ($query) use ($request) {
                            $query->where('start', '<=', $request->start)
                                ->where('end', '>=', $request->end);
                        });
                })
                ->where('status', '!=', 'cancelado')  // Excluimos las citas canceladas
                ->whereIn('status', ['pendiente', 'confirmado'])  // Solo incluimos las citas con estos estados
                ->where('id', '!=', $request->id_appointment)
                ->first();

            if ($existingAppointment) {
                Log::error('Ya existe una cita en ese horario.');
                return response()->json(['error' => 'Ya existe una cita en ese horario'], 400);
            }

            //Si el cliente es propietario, se asigna el cliente desde el request enviado.
            if (auth()->user()->role == 'propietario') {
                $client = $request->client ?? null;
                $client_id = $client;
            } else {
                $client_id = auth()->user()->id;
            }



            //Se crea la cita y recogemos las filas modificados en una variable.
            $appointment = Appointment::create([
                'start' => $request->start,
                'end' => $request->end,
                'status' => $request->input('status'),
                'service_id' => $request->input('service'),
                'client_id' => $client_id,
                'unregistered_client' => $request->unregistered_client,
                'hairdresser_id' => $request->hairdresser_id,
            ]);

            //Se comprueba que se ha creado la cita, si no, enviamos un error al usuario.
            if (!$appointment) {
                Log::error('Ha ocurrido un error al crear la cita.' . $appointment);
                return response()->json(['error' => 'Ha ocurrido un error al crear la cita'], 500);
            }

            //Si todo va bien, se envía un mensaje de exito al usuario.
            Log::info('Cita creada correctamente.');
            return response()->json(['message' => 'Cita creada correctamente']);
        } catch (\Exception $e) {
            Log::error('Error al crear la cita: ' . $e->getMessage());
            return response()->json(['error' => 'Ha ocurrido un error al procesar la solicitud'], 500);
        }
    }

    //Función que se encarga de actualizar una cita.
    public function updateAppointment(Request $request)
    {
        try {
            Log::info('Datos enviados en el Request:', $request->all());

            //Se validan los campos enviados
            $request->validate([
                'start' => 'nullable|date',
                'end' => 'nullable|date',
                'status' => 'required|in:pendiente,confirmado,cancelado',
                'service' => 'required|exists:services,id',
            ]);

            $start = Carbon::parse($request->start)->format('Y-m-d H:i:s');
            $end = Carbon::parse($request->end)->format('Y-m-d H:i:s');

            $existingAppointment = Appointment::where('hairdresser_id', $request->hairdresser_id)
                ->where(function ($query) use ($start, $end) {
                    $query->whereBetween('start', [$start, $end])
                        ->orWhereBetween('end', [$start, $end])
                        ->orWhere(function ($query) use ($start, $end) {
                            $query->where('start', '<=', $start)
                                ->where('end', '>=', $end);
                        });
                })
                ->where('status', '!=', 'cancelado')  // Excluimos las citas canceladas
                ->whereIn('status', ['pendiente', 'confirmado'])  // Solo incluimos las citas con estos estados
                ->where('id', '!=', $request->id_appointment)
                ->first();

            if ($existingAppointment) {
                Log::error('Ya existe una cita en ese horario.');
                return response()->json(['error' => 'Ya existe una cita en ese horario'], 400);
            }

            //Si en el request no existen valores para los campos start y end, no se actualizan.
            if ($request->input('start') == null || $request->input('end') == null) {
                Log::info('No se ha modificado la fecha de la cita.');
                $start = Appointment::find($request->id_appointment)->start;
                $end = Appointment::find($request->id_appointment)->end;
            } else {
                Log::info('Se ha modificado la fecha de la cita.');
                $start = $request->input('start');
                $end = $request->input('end');
            }

            $updated = Appointment::where('id', $request->id_appointment)->update([
                'start' => $start,
                'end' => $end,
                'status' => $request->input('status'),
                'service_id' => $request->input('service'),
            ]);

            // Comprobamos que se ha modificado alguna fila en nuestra base de datos, si no, enviamos un error al usuario.
            if ($updated === 0) {
                Log::error('No se encontró la cita o no hubo cambios');
                return response()->json(['error' => 'Cita no encontrada o no hubo cambios'], 404);
            }

            //Si todo va bien, se envía un mensaje de exito al usuario.
            Log::info('Cita actualizada correctamente.');
            return response()->json(['message' => 'Cita actualizada correctamente']);
        } catch (\Exception $e) {
            Log::error('Error al actualizar la cita: ' . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al actualizar la cita: ' . $e->getMessage()], 500);
        }
    }

    //Función que se encarga de eliminar una cita.
    public function deleteAppointment(Request $request)
    {
        try {

            //Se busca la cita por su id y se elimina.
            $appointment = Appointment::find($request->id_appointment);


            if (!$appointment) {
                Log::error('Cita no encontrada');
                return response()->json(['error' => 'Cita no encontrada'], 404);
            }
            $appointment->delete();

            //Si todo va bien, se envía un mensaje de exito al usuario.
            Log::info('Cita eliminada correctamente.');
            return response()->json(['message' => 'Cita eliminada correctamente']);
        } catch (\Exception $e) {
            Log::error('Error al eliminar la cita: ' . $e->getMessage());
            //Se maneja cualquier error que pueda ocurrir.
            return response()->json(['error' => 'Ocurrió un error al eliminar la cita: ' . $e->getMessage()], 500);
        }
    }



    //Función que se encarga de asignar un color al estado.
    private function getStatusColor($status)
    {
        return match ($status) {
            'pendiente' => '#FFC107',
            'confirmado' => '#4CAF50',
            'cancelado' => '#F44336',
            default => '#9E9E9E',
        };
    }
}
