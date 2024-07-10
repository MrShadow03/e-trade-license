<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Helpers\Helpers;
use App\Models\TradeLicenseApplication;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DataTableController extends Controller
{
    public function getTradeLicenseApplications(Request $request)
    {
        if ($request->ajax()) {
            $hasSearch = $request->has('search') && !empty($request->search['value']);
            $applications = TradeLicenseApplication::query();
            if ($hasSearch) {
                $search = $request->search['value'];
                $applications->where('business_organization_name_bn', 'like', "%$search%")
                    ->orWhere('business_organization_name', 'like', "%$search%")
                    ->orWhere('phone_no', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%")
                    ->orWhereHas('user', function($query) use ($search) {
                        $query->where('name_bn', 'like', "%$search%")
                            ->orWhere('name', 'like', "%$search%")
                            ->orWhere('phone', 'like', "%$search%")
                            ->orWhere('national_id_no', 'like', "%$search%");
                    });
            }

            // Ordering logic here
            if ($request->has('order')) {
                $order = $request->order[0];
                $columnIndex = $order['column']; // This is the index of the column to sort
                $sortDirection = $order['dir']; // This is the direction of sorting: 'asc' or 'desc'

                if ($columnIndex == 0) {
                    // Order by users name_bn
                    $applications->join('users', 'trade_license_applications.user_id', '=', 'users.id')
                        ->orderBy('users.name_bn', $sortDirection);
                } else if ($columnIndex == 1) {
                    // Order by business organization name
                    $applications->orderBy('business_organization_name_bn', $sortDirection);
                } else if ($columnIndex == 2) {
                    // Order by status
                    $applications->orderBy('status', $sortDirection);
                }
                // Add more conditions for other columns if needed
            } else {
                $applications->latest();
            }

            $applications = $applications->select('trade_license_applications.*');

            return DataTables::of($applications)
                ->addIndexColumn()
                ->addColumn('owner', function($row) {
                    $imageUrl = str_replace('localhost', 'localhost:' . env('LOCAL_PORT'), $row->getFirstMediaUrl('owner_image', 'thumb'));
                    $ownerName = $row->user?->name_bn;
                    $createdAt = Helpers::convertToBanglaDigits(Carbon::parse($row->created_at)->locale('bn-BD')->diffForHumans());
                    return '
                        <div class="d-flex align-items-center">
                            <a href="'.route('admin.trade_license_applications.show', $row->id).'" class="symbol symbol-50px me-5">
                                <img src="'.$imageUrl.'" alt="">
                            </a>
                            <div class="d-flex flex-column">
                                <a href="'.route('admin.trade_license_applications.show', $row->id).'" class="text-dark text-hover-primary fs-5 fw-bold d-block font-bn">'.$ownerName.'</a>
                                <span class="text-gray-600 fs-7 mt-1">'.$createdAt.'</span>
                            </div>
                        </div>';
                })
                ->addColumn('organization', function($row) {
                    $b_theme = 'success';
                    if ($row->ward_no > 10 && $row->ward_no <= 20) {
                        $b_theme = 'primary';
                    } else if ($row->ward_no > 20) {
                        $b_theme = 'info';
                    }
                    $natureOfBusinessBn = $row->nature_of_business_bn;
                    $phoneNo = $row->phone_no;
                    return '
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label bg-light-'.$b_theme.' border border-'.$b_theme.' border-dashed">
                                    <i class="fas fa-shop fs-2x text-'.$b_theme.'"></i>
                                </span>
                            </div>
                            <div>
                                <span class="text-dark fs-5 fw-bold font-bn">'.$row->business_organization_name_bn.'</span>
                                <span class="badge d-inline-block font-kohinoor badge-light-'.$b_theme.' fs-7">'.Helpers::convertToBanglaDigits($row->ward_no).' নং</span><br>
                                <a href="tel:'.$phoneNo.'" class="text-gray-600 fs-6 ls-1 mt-1 text-hover-primary">'.$phoneNo.'</a>
                            </div>
                        </div>';
                })
                ->addColumn('status', function($row) {
                    $data = Helpers::convertTlStatusToBangla($row->status);
                    $updatedAt = Helpers::convertToBanglaDigits(Carbon::parse($row->updated_at)->locale('bn-BD')->diffForHumans());
                    return '
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label bg-light-'.$data['theme'].' border border-'.$data['theme'].' border-dashed">
                                    <i class="fas '.$data['icon'].' fs-2x text-'.$data['theme'].'"></i>
                                </span>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="text-'.$data['theme'].' fs-5 font-bn">'.$data['msg_bn'].'</span>
                                <span class="text-gray-600 fs-7 mt-1">'.$updatedAt.'</span>
                            </div>
                        </div>';
                })
                ->addColumn('actions', function($row) {
                    $innerHtml = '';
                    if ($row->isValid()) {
                        $innerHtml .= '
                            <div class="d-flex justify-content-end">
                                <a href="#" class="btn btn-success btn-icon btn-sm me-1" data-bs-toggle="tooltip" title="ট্রেড লাইসেন্স দেখুন">
                                    <i class="fal fa-memo-circle-check fs-4"></i>
                                </a>
                            </div>';
                    }
                    $innerHtml .= '
                        <div class="d-flex justify-content-end">
                            <a href="'.route('admin.trade_license_applications.show', $row->id).'" class="btn btn-primary btn-icon btn-sm me-1" data-bs-toggle="tooltip" title="বিস্তারিত দেখুন">
                                <i class="fal fa-eye fs-4"></i>
                            </a>
                        </div>';
                    return $innerHtml;
                })
                ->rawColumns(['owner', 'organization', 'status', 'actions'])
                ->make(true);
        }
    }
}
