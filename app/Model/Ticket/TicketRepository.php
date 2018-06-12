<?php

namespace App\Model\Ticket;

use App\Model\Helpers;
use App\Model\Ticket\Ticket;

class TicketRepository
{
    use Helpers;

	/**
	 * Instantiate a repository's model.
	 *
	 * @return Ticket
	 */
	public function getModel()
	{
		return new Ticket;
    }

    /**
     * Filtro los tickets por usuario.
     *
     * @param $userName
     * @return void
     */
    public function ticketsByUserName(array $data)
    {
        if (isset($data['userName'])) {
            return $this->getModel()
                ->join('users', 'users.id', '=', 'tickets.user_id')
                ->where('users.username', $data['userName'])
                ->select('tickets.id', 'tickets.user_id', 'tickets.record_id', 'tickets.closed_by_id', 'tickets.status', 'tickets.comments')
                ->with('record', 'user')
                ->orderBy('status')
                ->orderBy('tickets.created_at', 'desc')
                ->paginate(1)
                ->appends($data);
        }

        return $this->getModel()
            ->with('record', 'user')
            ->orderBy('status')
            ->latest()
            ->paginate(12);
    }

    /**
     * Cierro el ticket.
     *
     * @param Ticket $ticket
     * @param Request $data
     * @return void
     */
    public function closeTicket(Ticket $ticket, $data)
    {
        $record = $ticket->record;
        $record->check_out = $this->toCarbon($data->get('check_out'));
        $record->save();

        $ticket->comments = $data->get('comments');
        $ticket->status = 'close';
        $ticket->closed_by_id = auth()->id();
        $ticket->save();
    }
}







