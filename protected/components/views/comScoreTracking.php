<script type="text/javascript">
    // <![CDATA[
    function sitestat(u) {
        var d = document, l = d.location;
        ns_pixelUrl = u + "&ns__t=" + (new Date().getTime());
        u = ns_pixelUrl + "&ns_c=" + ((d.characterSet) ? d.characterSet : d.defaultCharset) + "&ns_ti=" + escape(d.title) + "&ns_jspageurl=" + escape(l && l.href ? l.href : d.URL) + "&ns_referrer=" + escape(d.referrer);
        (d.images) ? new Image().src = u : d.write('<' + 'p><img src="' + u + '" height="1" width="1" alt="*"><' + '/p>');
    }
    ;
    sitestat("<?php echo $this->url; ?>");
    // ]]>
</script>
<noscript><p><img src="<?php echo $this->url; ?>" height="1" width="1" alt="*"/></p></noscript>
