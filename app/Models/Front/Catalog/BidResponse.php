<?php

namespace App\Models\Front\Catalog;

/**
 *
 */
class BidResponse
{

    /**
     * @return array
     */
    public static function same_as_max(): array
    {
        return [
            'status'  => 'same_as_max',
            'icon'    => 'ci-sliders',
            'message' => 'Već postoji ponuda sa ovim iznosom. Morati će te malo povečati ponudu?',
            'choose'  => 0
        ];
    }


    /**
     * @return array
     */
    public static function same_user_as_max(): array
    {
        return [
            'status'  => 'same_user_as_max',
            'icon'    => 'ci-sliders',
            'message' => 'Vaša ponuda je obnovljena.',
            'choose'  => 0
        ];
    }


    /**
     * @return array
     */
    public static function outbid(): array
    {
        return [
            'status'  => 'outbid',
            'icon'    => 'ci-add-user',
            'message' => 'Nažalost netko je dao veću ponudu! Pokušajte ponovo.',
            'choose'  => 0
        ];
    }


    /**
     * @return array
     */
    public static function success(): array
    {
        return [
            'status'  => 'success',
            'icon'    => 'ci-thumb-up',
            'message' => 'Hvala na ponudi. Potvrda je poslana na vaš email.',
            'choose'  => 0
        ];
    }


    /**
     * @return array
     */
    public static function error(): array
    {
        return [
            'status'  => 'error',
            'icon'    => 'ci-announcement',
            'message' => 'Nažalost dogodila se greška prilikom davanja ponude. Molimo pokušajte ponovo ili kontaktirajte administratora.',
            'choose'  => 0
        ];
    }
}
