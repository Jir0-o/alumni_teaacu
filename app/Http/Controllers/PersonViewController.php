<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Person;
use App\Models\SpecialAllowanceInformatio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonViewController extends Controller
{
    public function person_education_update(Request $request, $id, $education_id)
    {
        $validator = Validator::make($request->all(), [
            'passing_year' => 'required',
            'result' => 'required',
            'education_level_id' => 'required',
            'education_institute_id' => 'required',
            'education_board_universities_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill All Section'
            ]);
        }
        $getPeople = Person::find($id);
        $getdata = Education::where('id', $education_id)->first();
        $getdata->passing_year = $request->passing_year;
        $getdata->person_id = $request->person_id;
        $getdata->result = $request->result;
        $getdata->education_level_id = $request->education_level_id;
        $getdata->education_institute_id = $request->education_institute_id;
        $getdata->education_board_universities_id = $request->education_board_universities_id;
        $getdata->save();
        return response()->json([
            'status' => 200,
            'success' => 'Education Update Successfull'
        ]);
    }


    public function profession_information_add(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'institute_name' => 'required',
            'position' => 'required',
            'joined_year' => 'required',
            'retirement_year' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill All Section'
            ]);
        }
        $getPersonProfessionalInformation = new Experience;
        $getPersonProfessionalInformation->person_id = $id;
        $getPersonProfessionalInformation->institute_name = $request->institute_name;
        $getPersonProfessionalInformation->position = $request->position;
        $getPersonProfessionalInformation->joined_year = $request->joined_year;
        $getPersonProfessionalInformation->retirement_year = $request->retirement_year;
        $getPersonProfessionalInformation->save();
        return response()->json([
            'status' => 200,
            'success' => 'Professional Information Add Successfull'
        ]);
    }

    public function profession_information_get($id)
    {
        $getProfessionalInformation = Experience::where('experiences.person_id', $id)->get();
        if ($getProfessionalInformation == NULL) {
            return response()->json([
                'status' => false
            ]);
        }
        return response()->json([
            'getProfessionalInformation' => $getProfessionalInformation
        ]);
    }

    public function profession_information_update(Request $request, $id, $professional_information_id)
    {

        $validator = Validator::make($request->all(), [
            'update_institute_name' => 'required',
            'update_position' => 'required',
            'update_joined_year' => 'required',
            'update_retirement_year' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill All Section'
            ]);
        }

        $getdata = Experience::where('id', $professional_information_id)->get()->first();
        $getdata->institute_name = $request->update_institute_name;
        $getdata->position = $request->update_position;
        $getdata->person_id = $id;
        $getdata->joined_year = $request->update_joined_year;
        $getdata->retirement_year = $request->update_retirement_year;
        $getdata->save();
        return response()->json([
            'status' => 200,
            'success' => 'Professional Information Update Successfull'
        ]);
    }

    public function special_allowance_add(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'allowance_name' => 'required',
            'frequency' => 'required',
            'amount' => 'required|numeric|min:0',
        ]);
        if ($request->amount < 0) {
            return response()->json([
                'status' => 400,
                'errors' => 'Amount Section must be positive'
            ]);
        }
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill All Section'
            ]);
        }
        $getSpecialAllowance = new SpecialAllowanceInformatio;
        $getSpecialAllowance->person_id = $id;
        $getSpecialAllowance->allowance_name = $request->allowance_name;
        $getSpecialAllowance->frequency = $request->frequency;
        $getSpecialAllowance->amount = $request->amount;
        $getSpecialAllowance->save();
        return response()->json([
            'status' => 200,
            'success' => 'Special Allowance Add Successfull'
        ]);
    }

    public function special_allowance_get($id)
    {
        $SpecialAllowanceInformatio = SpecialAllowanceInformatio::where('special_allowance_informatios.person_id', $id)->get();
        if ($SpecialAllowanceInformatio == NULL) {
            return response()->json([
                'status' => false
            ]);
        }
        return response()->json([
            'SpecialAllowanceInformatio' => $SpecialAllowanceInformatio
        ]);
    }

    public function special_allowance_update(Request $request, $id, $special_allowance_information)
    {

        $validator = Validator::make($request->all(), [
            'update_allowance_name' => 'required',
            'update_frequency' => 'required',
            'update_amount' => 'required|numeric|min:0',
        ]);
        if ($request->update_amount < 0) {
            return response()->json([
                'status' => 400,
                'errors' => 'Amount Section must be positive'
            ]);
        }
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill All Section'
            ]);
        }

        $getdata = SpecialAllowanceInformatio::where('id', $special_allowance_information)->get()->first();
        $getdata->allowance_name = $request->update_allowance_name;
        $getdata->frequency = $request->update_frequency;
        $getdata->person_id = $id;
        $getdata->amount = $request->update_amount;
        $getdata->save();
        return response()->json([
            'status' => 200,
            'success' => 'Special Allowance Update Successfull'
        ]);
    }
}
