<?php

namespace App\Models\Users;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    static public function getAlltoSelectList() {
        return self::get()->map( function ( $s ) {
            return [
                'id'          => $s->id,
                'description' => $s->display_name
            ];
        } )->pluck( 'description', 'id' );
    }
}
