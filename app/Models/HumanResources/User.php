<?php

namespace App\Models\HumanResources;

use App\Helpers\DataHelper;
use App\Traits\ActiveTrait;
use App\Traits\AddressTrait;
use App\Traits\DateTimeTrait;
use App\Traits\User\NotificationTrait;
use App\Traits\UserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait; // add this trait to your user model
    use DateTimeTrait;
    use UserTrait;
    use AddressTrait;
    use ActiveTrait;
    use Notifiable;
    use NotificationTrait;
    use EntrustUserTrait {
        restore as private restoreA;
    } // add this trait to your user model

    use SoftDeletes {
        restore as private restoreB;
    }

    public function restore() {
        $this->restoreA();
        $this->restoreB();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'cpf',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $appends = [
        'cpf_formatted',
        'type_formatted',
        'created_at_time',
        'created_at_formatted',
        'deleted_at_time',
        'deleted_at_formatted',
    ];


	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================

    static public function getAlltoSelectList() {
        return self::get()->map( function ( $s ) {
            return [
                'id'          => $s->id,
                'description' => $s->getName()
            ];
        } )->pluck( 'description', 'id' );
    }

    public function updatePassword( $password ) {
        $this->password = bcrypt( $password );
        return $this->save();

        return $this->update( [
            'password' => bcrypt( $password )
        ] );
    }

    public function is( $name = null ) {
        $role = $this->roles->first();
        return ( $name == null ) ? $role : ( $role->name == $name );
    }

    public function getRoleName() {
        return $this->roles->first()->name;
    }

    public function getRoleId() {
        return $this->roles->first()->id;
    }

    public function itsMe($id) {
        return ($this->id == $id);
    }

    //============================================================
    //======================== ACCESSORS =========================
    //============================================================

    public function getTypeFormattedAttribute()
    {
        return $this->roles->first()->display_name;
    }

    public function getCpfFormattedAttribute()
    {
        return DataHelper::mask($this->getAttribute('cpf'), '###.###.###-##');
    }

    //============================================================
    //======================== MUTATORS ==========================
    //============================================================

    public function setCpfAttribute( $value )
    {
        return $this->attributes['cpf'] = DataHelper::getOnlyNumbers( $value );
    }

    //============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================

    //======================== BELONGS ===========================
    //============================================================

    //======================== HASONE ============================
    //============================================================

    //======================== HASMANY ===========================
    //============================================================

}
