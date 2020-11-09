<?php

use Projet\Model\App;

App::addScript('assets/js/page/map.js',true);
?>
<section class="ftco-section contact-section bg-light">
    <div class="container">
        <div class="row d-flex mb-5 contact-info">
            <div class="col-md-12 mb-4">
                <h2 class="h3">Contact Information</h2>
            </div>
            <div class="w-100"></div>
            <div class="col-md-3">
                <p><span>Téléphone:</span> <a href="tel://695113844">(+237) 695113844</a></p>
            </div>
            <div class="col-md-3">
                <p><span>Email:</span> <a href="mailto:jordanlontsi01@yahoo.com">jordanlontsi01@yahoo.com</a></p>
            </div>
        </div>
        <div class="row block-9">
            <div class="col-md-6 order-md-last d-flex">
                <form action="#" class="bg-white p-5 contact-form">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nom" id="nom" name="nom">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Email" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Sujet" id="sujet" name="sujet">
                    </div>
                    <div class="form-group">
                        <textarea name="" id="" cols="30" rows="7" class="form-control" placeholder="Message" id="description" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
                    </div>
                </form>
            </div>
            <div class="col-md-6 d-flex">
                <div id="map" class="bg-white"></div>
            </div>
        </div>
    </div>
</section>
<!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=A7QOK2M0TQLE&callback=loadmap" async defer></script>-->


