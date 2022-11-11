
<!-- latest -->
<section class='section section-latest'>
    <div class='packer'>
        <div class='package'>
            <div class='content'>
                <div class='heading'>
                    <h2>We have over <span class='highlighter'>41.970</span> offers just for you</h2>
                </div>
                <div class='carousel gap-stuck'>
                    <div class='carousel_items' data-nav=1>
                        <?php foreach ([
                            ["name" => "Goody's Burger House"],
                            ["name" => "The Big Bad Wolf"],
                            ["name" => "Roma Pizza"],
                            ["name" => "Pizza Fan"],
                            ["name" => "Bullseye"],
                            ["name" => "Mikel"]
                        ] as $item) :
                        ?>
                            <div class='item'>
                                <a href='place.php' class='item-offer'>
                                    <picture>
                                        <source srcset="https://placekitten.com/600/400" media="(min-width: 569px)" />
                                        <img loading="lazy" src='https://placekitten.com/400/300' />
                                    </picture>
                                    <div class='info'>
                                        <p class='mini-title'><?php echo $item["name"]; ?></p>
                                        <p>2 Extreme Deluxe</p>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class='heading'>
                    <h2>Partner Stores</h2>
                </div>
                <div class='carousel gap-stuck'>
                    <div class='carousel_items' data-nav=1>
                        <?php foreach ([
                            ["name" => "Goody's Burger House"],
                            ["name" => "The Big Bad Wolf"],
                            ["name" => "Roma Pizza"],
                            ["name" => "Pizza Fan"],
                            ["name" => "Bullseye"],
                            ["name" => "Mikel"]
                        ] as $item) :
                        ?>
                            <div class='item'>
                                <a href='place.php' class='item-offer'>
                                    <picture>
                                        <source srcset="https://placekitten.com/600/400" media="(min-width: 569px)" />
                                        <img loading="lazy" src='https://placekitten.com/400/300' />
                                    </picture>
                                    <div class='info'>
                                        <p class='mini-title'><?php echo $item["name"]; ?></p>
                                        <p>2 Extreme Deluxe</p>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>