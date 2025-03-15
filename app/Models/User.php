<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Front\Catalog\Auction\AuctionBid;
use App\Models\Roles\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable
{
    use HasApiTokens, HasRolesAndAbilities;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'front_username',
        'enabled'
    ];

    /**
     * @var Request
     */
    protected $request;


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function details()
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    }
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bids()
    {
        return $this->hasMany(AuctionBid::class, 'user_id')->with('auction');
    }


    /**
     * @return string
     */
    public function getFrontUsernameAttribute(): string
    {
        return substr($this->name, 0, 1) . '_' . substr(md5($this->name), 0, 4);
    }


    /**
     * @return string
     */
    public function getEnabledAttribute(): string
    {
        return $this->details->status;
    }


    /**
     * Validate new category Request.
     *
     * @param Request $request
     *
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255']
        ]);

        $this->request = $request;

        return $this;
    }


    /**
     * Validate new category Request.
     *
     * @param Request $request
     *
     * @return $this
     */
    public function validateFrontRequest(Request $request)
    {
        $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255']
        ]);

        $this->request = $request;

        return $this;
    }


    /**
     * Store new category.
     *
     * @return false
     */
    public function make()
    {
        if ( ! empty($this->request->password)) {
            $this->request->validate([
                'password' => ['required', 'string', 'confirmed']
            ]);
        }

        $user = User::create([
            'name'     => $this->request->username,
            'email'    => $this->request->email,
            'password' => Hash::make($this->request->password),
        ]);

        if ( ! isset($this->request->role) && $this->request->role == ''){
            $this->request->role = 'customer';
        }

        Bouncer::assign($this->request->role)->to($user);

        UserDetail::create([
            'user_id'    => $user->id,
            'fname'      => $this->request->fname,
            'lname'      => $this->request->lname,
            'address'    => $this->request->address,
            'zip'        => $this->request->zip,
            'city'       => $this->request->city,
            'state'      => $this->request->state,
            'phone'      => $this->request->phone,
            'company'      => $this->request->company,
            'oib'      => $this->request->oib,
            'avatar'     => 'media/avatars/avatar1.jpg',
            'bio'        => '',
            'social'     => '',
            'role'       => $this->request->role,
            'status'     => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return $user;
    }


    /**
     * @param Category $category
     *
     * @return false
     */
    public function edit()
    {
        if (isset($this->request->username)) {
            $this->update([
                'name'     => $this->request->username,
                'email'    => $this->request->email,
                'updated_at'       => Carbon::now()
            ]);
        }

        if (isset($this->request->password) && ! empty($this->request->password)) {
            $this->update([
                'password' => Hash::make($this->request->password),
            ]);
        }

        if ($this->id) {
            if (!isset($this->request->role)){
                $this->request->role = 'customer';
            }

            if (Role::checkIfChanged($this->id, $this->request->role)) {
                Role::change($this->id, $this->request->role);
            }

            UserDetail::where('user_id', $this->id)->update([
                'fname'      => $this->request->fname,
                'lname'      => $this->request->lname,
                'address'    => $this->request->address,
                'zip'        => $this->request->zip,
                'city'       => $this->request->city,
                'state'      => $this->request->state,
                'phone'      => $this->request->phone,
                'company'    => $this->request->company,
                'oib'        => $this->request->oib,
                'avatar'     => 'media/avatars/avatar1.jpg',
                'bio'        => '',
                'social'     => '',
                'role'       => $this->request->role,
                'status'     => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
                'updated_at' => Carbon::now()
            ]);

            return $this->find($this->id);
        }

        return false;
    }
}
