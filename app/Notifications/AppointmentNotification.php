<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentNotification extends Notification
{
    use Queueable;

    protected $appointment;
    protected $action;
    /**
     * Create a new notification instance.
     */
    public function __construct($appointment, $action, public bool $client)
    {
        $this->appointment = $appointment;
        $this->action = $action;
        $this->client = $client;
    }

    public function via($notifiable)
    {
        return ['database'];
    }
    
    public function toDatabase($notifiable)
    {
        return [
            'appointment_id' => $this->appointment->id,
            'client_name' => $this->appointment->client->name,
            'client_id' => $this->appointment->client->id,
            'service' => $this->appointment->service->name,
            'status' => $this->appointment->status,
            'action' => $this->action,
            'hairdresser_id' => $this->appointment->hairdresser->id,
            'hairdresser_name' => $this->appointment->hairdresser->name,
            'message' => $this->generateMessage(),
        ];
    }

    private function generateMessage()
{
    switch ($this->action) {
        case 'registrado':
            return $this->getMessage("registrado");
        case 'modificado':
            return $this->getMessage("modificado");
        case 'confirmado':
            return $this->getMessage("confirmado");
        case 'cancelado':
            return $this->getMessage("cancelado");
        case 'eliminado':
            return $this->getMessage("eliminado");
        default:
            return "Se ha realizado un cambio en la cita.";
    }
}

    private function getMessage($action)
    {

        if($this->client){
            switch ($action) {
                case 'registrado':
                    return "Se ha registrado una nueva cita para ti  ";
                case 'modificado':
                    return "Se ha modificado tu cita ";
                case 'confirmado':
                    return 'Se ha confirmado tu cita';
                case 'cancelado':
                    return "Se ha cancelado tu cita  ";
                case 'eliminado':
                    return "Se ha eliminado tu cita  ";
                default:
                    return "Se ha realizado un cambio en una cita para el cliente ";
            }

        } else{

            switch ($action) {
                case 'registrado':
                    return "Se ha registrado una nueva cita ";
                case 'modificado':
                    return "Se ha modificado una cita ";
                case 'cancelado':
                    return "Se ha cancelado una cita ";
                case 'eliminado':
                    return "Se ha eliminado una cita ";
                default:
                    return "Se ha realizado un cambio en una cita ";
            }

        }
        
            
        
    }
    
}
