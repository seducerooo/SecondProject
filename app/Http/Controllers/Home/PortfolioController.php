<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Image;

class PortfolioController extends Controller
{
    //
    public function AllPortfolio(){
        $portfolio = Portfolio::query()->latest()->get();
        return view('admin.portfolio.portfolio_all',compact('portfolio'));
    }
    public function AddPortfolio(){
        return view('admin.portfolio.portfolio_add');
    }
    public function StorePortfolio(Request $request){
        $request->validate([
            'portfolio_name' => 'required|',
            'portfolio_title' => 'required',
            'portfolio_image' => 'required'
        ],
            [
                'portfolio_name.required' => 'Portfolio Name is required',
                'portfolio_title.required' => 'Portfolio title is required'
             ]
        );


        $image = $request->file('portfolio_image');

            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(1020, 519)->save('upload/portfolio/' . $name_gen);

            $save_url = 'upload/portfolio/' . $name_gen;

            Portfolio::query()->insert([
                'portfolio_name' => $request['portfolio_name'],
                'portfolio_title' => $request['portfolio_title'],
                'portfolio_image' => $save_url,
                'portfolio_description' => $request['portfolio_description'],
                'created_at' => Carbon::now()
            ]);

        $notification = array(
            'message' => 'Portfolio Inserted  Successfully',
            'alert-type' => 'success',
        );
        return to_route('all.portfolio')->with($notification);




    }
    public function EditPortfolio(string $id){
        $portfolio = Portfolio::query()->find($id);

        return view('admin.portfolio.portfolio_edit',compact('portfolio'));
    }
    public function UpdatePortfolio(Request $request ,string $id){
        $portfolio = $request->file('portfolio_image');

        $name_gen = hexdec(uniqid()) . '.' . $portfolio->getClientOriginalExtension();

        Image::make($portfolio)->resize(1020, 519)->save('upload/portfolio/' . $name_gen);

        $save_url = 'upload/portfolio/' . $name_gen;

        $UpdatePortfolio = new Portfolio();
        $UpdatePortfolio->portfolio_name = $request['portfolio_name'];
        $UpdatePortfolio->portfolio_title = $request['portfolio_title'];
        $UpdatePortfolio->portfolio_description = $request['portfolio_description'];
        $UpdatePortfolio->portfolio_image = $save_url;
        $UpdatePortfolio->updated_at = $request['updated_at'];
        $UpdatePortfolio->save();

        $notification = array(
            'message' => ' Portfolio Updated  Successfully',
            'alert-type' => 'success',
        );
        return to_route('all.portfolio')->with($notification);
    }
    public function DestroyPortfolio(string $id){
        $notification = array(
            'message' => 'Portfolio Deleted  Successfully',
            'alert-type' => 'success',
        );
//        DB::table('multi_images')->where('id', $id)->delete();
        $portfolio = Portfolio::query()->find($id);
        $img = $portfolio->portfolio_image;
        unlink($img);
        Portfolio::query()->findOrFail($id)->delete();

        return to_route('all.portfolio')->with($notification);

    }

    public function PortfolioDetails(string $id){
        $portfolio =  Portfolio::query()->findOrFail($id);
        return view( 'frontend.portfolio_details',compact('portfolio'));
    }
}
