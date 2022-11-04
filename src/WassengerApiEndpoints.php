<?php
namespace Alresia\LaravelWassenger;


/**
 * @internal
 */
class WassengerApiEndpoints
{
    
     /**
     * Registers a set of default routes for dealing with Messages.
     *
     * 
     */
    public const SEARCH_MESSAGES = ['messages', 'GET'];
    public const SEND_MESSAGE = ['messages', 'POST'];
    public const GET_MESSAGE_BY_ID = ['messages', 'GET', true];
    public const UPDATE_MESSAGE = ['messages', 'PATCH', true];
    public const DELETE_MESSAGE = ['messages', 'DELETE', true];


    public const NUMBER_EXIST = ['numbers/exists', 'POST'];
    public const DEVICE_SYNC = ['devices/{deviceId}/sync', 'GET'];
   
    
}
