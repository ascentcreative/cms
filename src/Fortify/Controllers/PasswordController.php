<?php

namespace AscentCreative\CMS\Fortify\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class PasswordController extends \Laravel\Fortify\Http\Controllers\PasswordController
{
    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Fortify\Contracts\UpdatesUserPasswords  $updater
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UpdatesUserPasswords $updater)
    {
        $updater->update($request->user(), $request->all());

        return $request->wantsJson()
                    ? new JsonResponse(view('account.modals.passwordupdated')->render(), 200)
                    : back()->with('status', 'password-updated');
    }
}
