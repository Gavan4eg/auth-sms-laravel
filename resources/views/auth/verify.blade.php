@extends('layouts.app')
@section('content')
    <main id="success-page">
        <section class="page-form">
            <div class="page-form__container">
                <div class="page-form__wrapper">
                    <form action="{{ route('auth.verify.code') }}" method="post" id="myForm" class="page-form__info form">
                        @csrf
                        <h3 class="form__title">Введіть код</h3>
                        <div class="form__wrap">
                            <div class="form__item">
                                <div class="form__number">
                                    <input data-required data-validate name="number-1" class="number_input" type="number" max_n=1 tabindex=1>
                                    <input data-required data-validate name="number-2" class="number_input" type="number" max_n=1 tabindex=2>
                                    <input data-required data-validate name="number-3" class="number_input" type="number" max_n=1 tabindex=3>
                                    <input data-required data-validate name="number-4" class="number_input" type="number" max_n=1 tabindex=4>
                                </div>
                                <input name="code" class="number_input--hidden" type="number" max_n=4>
                            </div>
                        </div>
                        @if(session('error'))
                            {{ session('error') }}
                        @endif
                        <button type="submit" class="form__button btn">Підтвердити</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
