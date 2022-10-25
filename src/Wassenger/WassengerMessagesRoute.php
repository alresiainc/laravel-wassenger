<?php
namespace Alresia\LaravelWassenger\Messages;


/**
 * @internal
 */
class WassengerMessagesRoute
{
    
     /**
     * Registers a set of default routes for dealing with Messages.
     *
     * 
     */
    public const SEARCH_MESSAGES = ['messages', 'GET'];
    public const SEND_MESSAGE = ['messages', 'POST'];
    public const GET_MESSAGE_BY_ID = ['messages', 'GET'];

    // Attestation variables to limit the authenticator conveyance.
    public const UPDATE_MESSAGE = ['messages', 'PATCH'];
    public const DELETE_MESSAGE = ['messages', 'DELETE',];
   
    
}
