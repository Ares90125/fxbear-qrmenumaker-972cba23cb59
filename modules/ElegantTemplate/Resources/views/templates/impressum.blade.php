
<!-- impressum-->
<section class='section section-areas'>
    <div class='packer'>
        <div class='package'>
            <div class='content'>
                <div class='heading'>
                    <h2>{{ __($restorant->getConfig('impressum_title','')) }}</h2>
                </div>
                <div class=''>
                    <?php echo __($restorant->getConfig('impressum_value','')); ?>
                </div>
            </div>
        </div>
    </div>
</section>