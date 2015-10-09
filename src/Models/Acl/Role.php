<?php
/*
This file is part of SeAT

Copyright (C) 2015  Leon Jacobs

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

namespace Seat\Web\Models\Acl;

use Illuminate\Database\Eloquent\Model;
use Seat\Web\Models\User;

/**
 * Class Role
 * @package Seat\Web\Models\Acl
 */
class Role extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['title'];

    /**
     * Make sure we cleanup on delete
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {

        // Remove the Role from users, permissions
        // and affiliations that it had
        $this->users()->detach();
        $this->permissions()->detach();
        $this->affiliations()->detach();

        return parent::delete();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {

        return $this->belongsToMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {

        return $this->belongsToMany(Permission::class);
    }

    /**
     * This role may be affiliated manually to
     * other characterID's and or corporations
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function affiliations()
    {

        return $this->belongsToMany(Affiliation::class);
    }
}