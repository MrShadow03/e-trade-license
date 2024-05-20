<?php

namespace App\Policies;

use App\Helpers\Helpers;
use App\Models\Admin;
use App\Models\TradeLicenseApplication;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TradeLicenseApplicationPolicy
{

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, TradeLicenseApplication $tradeLicenseApplication): bool
    {
        return $user->id == $tradeLicenseApplication->user_id;
    }


    public function create(User $user): bool
    {
        return true;
    }

    public function correct(User $user, TradeLicenseApplication $tradeLicenseApplication): bool
    {
        return  $user->id == $tradeLicenseApplication->user_id && Helpers::needsApplicationCorrection($tradeLicenseApplication->status);
    }

    public function update(User $user, TradeLicenseApplication $tradeLicenseApplication): bool
    {
        return  $user->id == $tradeLicenseApplication->user_id &&
                $tradeLicenseApplication->status === Helpers::PENDING_FORM_FEE_PAYMENT;
    }


    public function delete(User $user, TradeLicenseApplication $tradeLicenseApplication): bool
    {
        return  $user->id == $tradeLicenseApplication->user_id &&
                $tradeLicenseApplication->status === Helpers::PENDING_FORM_FEE_PAYMENT;
    }

    public function restore(User $user, TradeLicenseApplication $tradeLicenseApplication)
    {
        //
    }

    public function forceDelete(User $user, TradeLicenseApplication $tradeLicenseApplication)
    {
        //
    }

    public function payFormFee(User $user, TradeLicenseApplication $tradeLicenseApplication): bool {
        return  $user->id == $tradeLicenseApplication->user_id &&
                ($tradeLicenseApplication->status === Helpers::PENDING_FORM_FEE_PAYMENT || $tradeLicenseApplication->status === Helpers::DENIED_FORM_FEE_VERIFICATION);
    }
    
    public function payLicenseFee(User $user, TradeLicenseApplication $tradeLicenseApplication): bool {
        return  $user->id == $tradeLicenseApplication->user_id &&
                ($tradeLicenseApplication->status === Helpers::PENDING_LICENSE_FEE_PAYMENT || $tradeLicenseApplication->status === Helpers::DENIED_LICENSE_FEE_VERIFICATION);
    }

    public function hasApprovalPermission(Admin $admin, TradeLicenseApplication $tradeLicenseApplication): bool {
        return $admin->can('approve-pending-trade-license-assistant-approval-applications') && $tradeLicenseApplication->status === Helpers::PENDING_ASSISTANT_APPROVAL ||
        $admin->can('approve-pending-trade-license-inspector-approval-applications') && $tradeLicenseApplication->status === Helpers::PENDING_INSPECTOR_APPROVAL ||
        $admin->can('approve-pending-trade-license-superintendent-approval-applications') && $tradeLicenseApplication->status === Helpers::PENDING_SUPT_APPROVAL ||
        $admin->can('approve-pending-revenue-officer-approval-applications') && $tradeLicenseApplication->status === Helpers::PENDING_RO_APPROVAL ||
        $admin->can('approve-pending-chief-revenue-officer-approval-applications') && $tradeLicenseApplication->status === Helpers::PENDING_CRO_APPROVAL ||
        $admin->can('approve-pending-chief-executive-officer-approval-applications') && $tradeLicenseApplication->status === Helpers::PENDING_CEO_APPROVAL;
        
    }
}
