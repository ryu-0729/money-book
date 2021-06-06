<?php

namespace App\Http\Controllers;

use App\Models\BuyItem;
use Illuminate\Http\Request;
use App\Repositories\BuyItemRepository; // BuyItemRepositoryを使用

class BuyItemController extends Controller
{
    private $buyItemRepository;

    public function __construct(BuyItemRepository $buyItemRepository)
    {
        $this->buyItemRepository = $buyItemRepository;
    }

    public function index()
    {
        $userBuyItems = $this->buyItemRepository->getAll();
        return view('buy_items.index', compact('userBuyItems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BuyItem  $buyItem
     * @return \Illuminate\Http\Response
     */
    public function show(BuyItem $buyItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BuyItem  $buyItem
     * @return \Illuminate\Http\Response
     */
    public function edit(BuyItem $buyItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BuyItem  $buyItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BuyItem $buyItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BuyItem  $buyItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuyItem $buyItem)
    {
        //
    }
}
