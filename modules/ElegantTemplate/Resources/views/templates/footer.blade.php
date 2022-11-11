
<!-- footer-->
<div id='footer'>
    <div class='packer'>
        <ul id="footer-pages" class="nav nav-footer justify-content-end">
            <li v-for="page in pages" class="nav-item" v-cloak>
                <a :href="'/pages/' + page.id" class="nav-link">@{{ page.title }}</a>
            </li>
        </ul>
    </div>
    <div class='copyright'>
        <div class='packer'>
            <div class='package'> &copy; {{ date('Y') }} <a href="" target="_blank">{{ config('global.site_name', 'mResto') }}</a>.</div>
        </div>
    </div>
</div>