<?php 

namespace Helvetitec\Messaging\Enums\Uazapi;

enum GroupParticipantAction: string
{
    /**
     * Add to group.
     */
    case ADD = 'add';
    /**
     * Remove from group.
     */
    case REMOVE = 'remove';
    /**
     * Add admin rights.
     */
    case PROMOTE = 'promote';
    /**
     * Remove admin rights.
     */
    case DEMOTE = 'demote';
    /**
     * Accept pending request to enter group.
     */
    case APPROVE = 'approve';
    /**
     * Reject pending request to enter group.
     */
    case REJECT = 'reject';
}