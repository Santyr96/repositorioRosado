<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    public function clientIndex(Request $request)
    {
        try {
            $user = auth()->user();

            //Función que se encarga de recuperar las citas del cliente en la peluqueria seleccionada por el cliente.
            $appointments = Appointment::with(['service', 'hairdresser'])
                ->where('hairdresser_id', $request->hairdresser_id)
                ->orWhere('client_id', $user->id)
                ->get()
                ->map(function ($appointment) {
                    //Asignación del color del evento según el estado de la cita.
                    $statusColor = $this->getStatusColor($appointment->status);

                    //Se retorna la información de la cita en un formato adecuado para FullCalendar.
                    return [
                        'appointment_id' => $appointment->id,
                        'title' => "Cliente: {$appointment->client->name} - Servicio: {$appointment->service->name}",
                        'start' => $appointment->start->toIso8601String(),
                        'end' => $appointment->end ? $appointment->end->toIso8601String() : null,
                        'color' => $statusColor,
                        'status' => $appointment->status,
                        'service_id' => $appointment->service_id,
                        'service_name' => $appointment->service->name,
                        'client_id' => $appointment->client_id,
                        'hairdresser_id' => $appointment->hairdresser_id,
                    ];
                });

            //Se retorna las citas en formato JSON.
            return response()->json($appointments);

            //Capturamos las posibles excepciones y mandamo un JSON por si queremos mostrar información del error al cliente.
        } catch (\Exception $e) {
            Log::error('Error al obtener las citas del cliente', [
                'error_message' => $e->getMessage(),
                'error_stack' => $e->getTraceAsString(),
                'user_id' => auth()->user()->id,
                'hairdresser_id' => $request->hairdresser_id,
            ]);
            return response()->json(['error' => 'Ha ocurrido un error al procesar la solicitud'], 500);
        }
    }

    //Función que se encarga de actualizar una cita.
    public function updateAppointment(Request $request)
    {
        try {

            //Se validan los campos enviados
            $request->validate([
                'start' => 'required|date',
                'end' => 'required|date',
                'status' => 'required|in:pendiente,confirmado,cancelado',
                'service' => 'required|exists:services,id', 
            ]);

            //Si la hora marcada en el request es igual a otra cita, lanzamos un error.
            $existingAppointment = Appointment::where('hairdresser_id', $request->hairdresser_id)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('start', [$request->start, $request->end])
                        ->orWhereBetween('end', [$request->start, $request->end])
                        ->orWhere(function ($query) use ($request) {
                            $query->where('start', '<=', $request->start)
                                ->where('end', '>=', $request->end);
                        });
                })
                ->where('id', '!=', $request->id_appointment)
                ->first();

            if ($existingAppointment) {
                return response()->json(['error' => 'Ya existe una cita en ese horario'], 400);
            }

            //Se realiza la actualización de solo los campos indicados y recogemos las filas modificados en una variable.
            $updated = Appointment::where('id', $request->id_appointment)->update([
                'start' => $request->input('start'),
                'end' => $request->input('end'),
                'status' => $request->input('status'),
                'service_id' => $request->input('service'),
            ]);

            // Comprobamos que se ha modificado alguna fila en nuestra base de datos, si no, enviamos un error al usuario.
            if ($updated === 0) {
                return response()->json(['error' => 'Cita no encontrada o no hubo cambios'], 404);
            }

            //Si todo va bien, se envía un mensaje de exito al usuario.
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
                return response()->json(['error' => 'Cita no encontrada'], 404);
            }
            $appointment->delete();

            //Si todo va bien, se envía un mensaje de exito al usuario.
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
