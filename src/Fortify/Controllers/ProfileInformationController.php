<?php

namespace AscentCreative\CMS\Fortify\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class ProfileInformationController extends \Laravel\Fortify\Http\Controllers\ProfileInformationController
{
    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Fortify\Contracts\UpdatesUserProfileInformation  $updater
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,
                           UpdatesUserProfileInformation $updater)
    {
        $updater->update($request->user(), $request->all());

        return $request->wantsJson()
                    ? new JsonResponse(view('account.modals.profileupdated')->render(), 200)
                    : back()->with('status', 'profile-information-updated');
    }
}
