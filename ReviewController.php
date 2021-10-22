<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

        public function index()
        {
            if (Review::count() != 0) {

                $review= Review::orderBy('serial', 'asc')->get(['id','client_name','client_photo','client_designation',
                'client_review','status','serial']);;
                return view('clientreviews.index',[
                'review' => $review
                ]);
        }
            else{
        return $this->create();
            }
        }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clientreviews.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_photo'=>'required|image|mimes:jpeg,png,jpg|max:5000',
            'client_name'=>'required|max:50|string',
            'client_designation'=>'max:150',
            'client_review'=>'required|string|max:65000',
        ]);
        $up_pic=$request->file('client_photo');
        $new_pic_name="client's-review-".str_replace("-", " ",$request->client_name).'-'.str_replace("-", " ",$request->client_designation).'-'.date('h-m-s').".".$up_pic->getClientOriginalExtension();
        $new_pic_location='public/uploads/clientreviews/'.$new_pic_name;

        Image::make($up_pic)->save(base_path($new_pic_location));
        $total=Review::count();
        Review::create($request->only(['client_name','client_designation','client_review',
        ]) + ['client_photo' => $new_pic_name, 'serial' => $total+1
        ]);
        return redirect()->route('client-reviews.index')->with('status','Your Client Review has been Added...');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    // public function show(Review $review)
    // {

    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $client_review)
    {
        return view('clientreviews.edit',[
            'review' => $client_review
        ]);
        // echo "dd";
        // dd($clientreviews);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $client_review)
    {

        $request->validate([
            'client_photo'=>'required|image|mimes:jpeg,png,jpg|max:5000',
            'client_name'=>'required|max:50|string',
            'client_designation'=>'max:150',
            'client_review'=>'required|string|max:65000',
            // 'status'=>'required|integer|min:1|max:2',
            'serial'=>'required|integer|min:1',
        ]);
        if ($request->hasFile('client_photo')) {
            $old_pic_location='public/uploads/clientreviews/'.$client_review->client_photo;
            unlink(base_path($old_pic_location));
        $up_pic=$request->file('client_photo');
        $new_pic_name="client's-review-".str_replace("-", " ",$request->client_name).'-'.str_replace("-", " ",$request->client_designation).'-'.date('h-m-s').".".$up_pic->getClientOriginalExtension();
        $new_pic_location='public/uploads/clientreviews/'.$new_pic_name;
        Image::make($up_pic)->save(base_path($new_pic_location));
        $client_review->update($request->only([
            'client_name','client_designation','client_review','status','serial',
        ]) + ['client_photo' => $new_pic_name,] );
            }
        else{
            $client_review->update($request->only([
                'client_name','client_designation','client_review','status','serial',
            ]));
        }
        return redirect()->route('client-reviews.index')->with('status','Your Client Review has been Updated...');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    // public function destroy(Review $review)
    {
        if (Auth::user()->roll == 1001) {

            $old_pic_name=Review::where('id', $request->id)->pluck('client_photo')->first();
            $old_pic_location='public/uploads/clientreviews/'.$old_pic_name;
            if ($old_pic_name != 'dafault.png') {
                unlink(base_path($old_pic_location));
            }
            Review::find($request->id)->delete();
            return back()->with('status1','Delete Successfull...');
        }   else {
            return back()->with('status1',"You Don't have the Permission to Delete...");
        }
    }


    public function clientreviews_status($id ,$status ){
        $review= Review::where('id',$id)->first();
        $review->status =$status;
        $review->save();
        return back();
        }
}
