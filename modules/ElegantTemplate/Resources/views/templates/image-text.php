
<!-- image-text-->
<section class='section section-image-text reverse'>
    <div class='packer'>
        <div class='package'>
            <div class='content'>
                <div class='heading'>
                    <h2>What are you in the mood for today?</h2>
                </div>
                <div class='gap-stuck'>
                    <p>Anything you want, whenever you want! A coffee is mandatory when you wake up. We know that. You forgot to buy diapers. Or beer. Or milk. We've got it! That lasagna you forgot to cook. We bring that to you. And the eggs you need for that recipe. Find them all here!</p>
                    <p><strong>85 different store categories just for you</strong></p>
                    <nav class='inline-links'>
                        <?php foreach (["Coffee", "Pizza", "Chinese", "Crepes", "Burgers", "Sushi", "Pasta", "Mexican", "Indian", "Vegan", "Vegetarian", "Salad", "Asian", "Bagels"] as $item) : ?>
                            <div class='item'>
                                <a href='javascript:;'><?php echo $item; ?></a>
                            </div>
                        <?php endforeach; ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <picture data-background=true>
        <source srcset="https://placekitten.com/800/800" media="(min-width: 569px)" />
        <img loading="lazy" src='https://placekitten.com/400/400' />
    </picture>
</section>