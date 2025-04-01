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
            'status' => 'same_as_max',
            'message' => 'Želite li povečati ponudu',
            'choose' => 1
        ];
    }


    /**
     * @return array
     */
    public static function outbid(): array
    {
        return [
            'status' => 'outbid',
            'message' => 'Nažalost netko je dao veću ponudu! Pokušajte ponovo.',
            'choose' => 0
        ];
    }


    /**
     * @return array
     */
    public static function success(): array
    {
        return [
            'status' => 'success',
            'message' => 'Hvala na ponudi. Potvrda je poslana na vaš email.',
            'choose' => 0
        ];
    }


    /**
     * @return array
     */
    public static function error(): array
    {
        return [
            'status' => 'error',
            'message' => 'Nažalost dogodila se greška prilikom davanja ponude. Molimo pokušajte ponovo ili kontaktirajte administratora.',
            'choose' => 0
        ];
    }
}