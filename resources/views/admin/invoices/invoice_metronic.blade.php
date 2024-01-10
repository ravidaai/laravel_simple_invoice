@extends('admin.layout.master')

@section('title')
    Print
@stop

@section('css')

@stop

@section('breadcrumb')
    <div class="mr-auto">
        <h3 class="m-subheader__title m-subheader__title--separator">
            Dashboard
        </h3>
        <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
            <li class="m-nav__item m-nav__item--home">
                <a href="{{ route('admin.invoices.view') }}" class="m-nav__link m-nav__link--icon">
                    <i class="m-nav__link-icon flaticon-placeholder-2"></i>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.invoices.view') }}" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Invoice
                    </span>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.invoices.invoice', ['id' => $info->id_hash]) }}" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Print
                    </span>
                </a>
            </li>
        </ul>
    </div>
@stop


@section('content')
    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet">
                    <div class="m-portlet__body m-portlet__body--no-padding">
                        <div class="m-invoice-2">
                            <div class="m-invoice__wrapper">
                                <div class="m-invoice__head" style="background-image: url(assets/admin/app/media/img//logos/bg-6.jpg);">
                                    <div class="m-invoice__container m-invoice__container--centered">
                                        <div class="m-invoice__logo">
                                            <a href="#">
                                                <h1>INVOICE</h1>
                                            </a>
                                            <a href="#">
                                                <img width="203" height="50" src="{{ asset('uploads/companies/'.optional($info->company)->logo) }}">
                                            </a>
                                        </div>
                                        <span class="m-invoice__desc">
															<span>{{ optional($info->company)->name }}, {{ optional($info->company)->address }}, {{ optional(optional($info->company)->city)->name }}</span>
															<span>{{ optional(optional($info->company)->country)->name }} {{ optional($info->company)->postal_code }}</span>
														</span>
                                        <div class="m-invoice__items">
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">DATA</span>
                                                <span class="m-invoice__text">{{ date("M d, Y",strtotime($info->invoice_date)) }}</span>
                                            </div>
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">INVOICE NO.</span>
                                                <span class="m-invoice__text">CR - {{ $info->number }}</span>
                                            </div>
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">INVOICE TO.</span>
                                                <span class="m-invoice__text">{{ optional($info->contact)->display_name }}, {{ optional($info->contact)->address }}.<br>{{ optional(optional($info->contact)->country)->name }} - {{ optional(optional($info->contact)->city)->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-invoice__body m-invoice__body--centered">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Tax</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($info->items as $row)
                                            <tr>
                                                <td>{{ optional($row->item)->name }}</td>
                                                <td>{{ $row->quantity }}</td>
                                                <td>{{ $row->price }}</td>
                                                <td>{{ $row->tax }}</td>
                                                <td class="m--font-danger">{{ $row->total }}</td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="m-invoice__footer">
                                    <div class="m-invoice__table  m-invoice__table--centered table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Total Before Taxes</th>
                                                <th>Discount</th>
                                                <th>Tax</th>
                                                <th>TOTAL</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>{{ $info->subtotal - $info->tax }}</td>
                                                <td>{{ $info->discount }}</td>
                                                <td>{{ $info->tax }}</td>
                                                <td class="m--font-danger">{{ $info->total }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
@stop