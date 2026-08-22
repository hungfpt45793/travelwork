<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 6/25/2019
 * Time: 4:26 PM
 */

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Integer;
use Validator;

class JobManagerController extends SiteController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {


        } catch (\Exception $e) {
            $contacts = null;
        } finally {
            return view('admin.contact.list', compact('contacts'));
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin.contact.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if slug null slug create as title
        $this->insertContact($request);

        return redirect(route('contact.index'));
    }

    private function insertContact($request) {
        try {
            $contact = new Contact();
            $contact->insert([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                'status' => $request->input('status'),
                'message' => $request->input('message'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
        } catch(\Exception $e) {
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(int  $id)
    {
        return View('admin.contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {

        return redirect(route('contact.index'));
    }

    private function updateContact(int $id, $request) {
        try {

        } catch (\Exception $e) {

        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {

        return redirect(route('contact.index'));
    }
}