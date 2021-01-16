@extends('layouts.app')

@section('content')


<div class="flex-center position-ref full-height">

    <div class="content">
    <!---new content-->

        <!-- Banner -->
        <section id="banner">
            <div class="inner">
                <img class="img-responsive" src="{{asset('images/elitevip_logo.svg')}}" alt="logo elite experience vip">
            </div>
            <video autoplay loop muted playsinline src="{{ asset("videos/elite_intro.mp4")}}"></video>
        </section>

        <!-- Highlights -->
        <section class="wrapper">
            <div class="inner">
                <header class="special">
                    <h2>Nuestros eventos</h2>
                </header>
                <div class="highlights">
                    <section>
                        <div class="content">
                            <header>
                                <a href="#" class="icon fa-vcard-o"><span class="label">Icon</span></a>
                                <h3>Feugiat consequat</h3>
                            </header>
                            <p>Nunc lacinia ante nunc ac lobortis ipsum. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus.</p>
                        </div>
                    </section>
                    <section>
                        <div class="content">
                            <header>
                                <a href="#" class="icon fa-files-o"><span class="label">Icon</span></a>
                                <h3>Ante sem integer</h3>
                            </header>
                            <p>Nunc lacinia ante nunc ac lobortis ipsum. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus.</p>
                        </div>
                    </section>
                    <section>
                        <div class="content">
                            <header>
                                <a href="#" class="icon fa-floppy-o"><span class="label">Icon</span></a>
                                <h3>Ipsum consequat</h3>
                            </header>
                            <p>Nunc lacinia ante nunc ac lobortis ipsum. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus.</p>
                        </div>
                    </section>
                    <section>
                        <div class="content">
                            <header>
                                <a href="#" class="icon fa-line-chart"><span class="label">Icon</span></a>
                                <h3>Interdum gravida</h3>
                            </header>
                            <p>Nunc lacinia ante nunc ac lobortis ipsum. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus.</p>
                        </div>
                    </section>
                    <section>
                        <div class="content">
                            <header>
                                <a href="#" class="icon fa-paper-plane-o"><span class="label">Icon</span></a>
                                <h3>Faucibus consequat</h3>
                            </header>
                            <p>Nunc lacinia ante nunc ac lobortis ipsum. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus.</p>
                        </div>
                    </section>
                    <section>
                        <div class="content">
                            <header>
                                <a href="#" class="icon fa-qrcode"><span class="label">Icon</span></a>
                                <h3>Accumsan viverra</h3>
                            </header>
                            <p>Nunc lacinia ante nunc ac lobortis ipsum. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus.</p>
                        </div>
                    </section>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section id="cta" class="wrapper">
            <div class="inner">
                <h2 class="title-bg-black">Reproduce videos de eventos exclusivos en vivo</h2>
                <p class="title-small">Accede a nuestras galerias de videos y obten beneficios por la membresia VIP.</p>
            </div>
        </section>




    <!---new content-->






    </div>
</div>


    @endsection