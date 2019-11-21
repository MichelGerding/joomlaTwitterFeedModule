<?php
// No direct access
defined('_JEXEC') or die;

if (!empty($items)):?>
    <div class="owl-carousel">
        <?php foreach ($items as $item): ?>
            <div class="tks-twitter-item twitter-<?php echo $item->type; ?>">
                <div class="tks-twitter-body">
                	<?php if($item->image !== ""): ?>
                        <div class="tks-twitter-image" style="background:url(<?php echo $params['saveDir'] . $item->image; ?>); background-position:center; background-size:cover;">
                        </div>
                    <?php else: ?>
                        <?php if($params->get('ViewType')/* && !== 'T'*/): ?>
                        <div class="tks-twitter-image" style="background:url(<?php echo $params['placeholder']; ?>); background-position:center; background-size:cover;">
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="tks-twitter-content">
                        <div class="tks-twitter-message">
                            <?php if ($params->get('truncate')) {
                                $txt = JHTML::_('string.truncate', ($msg), $params->get('maxChars')); 
                            } else {
                                echo $item->text; }?>   
                        </div>
                        <?php if($params['showDate'] == 1): ?>
                            <div class="tks-twitter-date"><?php echo date("j F Y", strtotime($item->created_at)); ?></div>
                        <?php endif; ?>
                        <div class="tks-twitter-likes">
                            <i class="fa fa-heart" aria-hidden="true"></i> <?php echo $item->favorite; ?>
                        </div>
                        <div class="tks-twitter-leesmeer">
                            <a href="<?php echo $item->link; ?>" target="_blank">lees meer</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <script>
        let params = JSON.parse('<?php echo $params->get('breakpoints')?>');

        let responsive = JSON.parse(getUsefullJSON(params));

        jQuery('.owl-carousel').owlCarousel({
            <?php
            if (trim($params->get('loop'))) echo "loop:" . $params->get('loop') . ",";
            if (trim($params->get('margin'))) echo "margin:" . $params->get('margin') . ",";
            if (trim($params->get('nav'))) echo "nav:" . $params->get('nav') . ",";
            echo "dots:" . $params->get('dots') . ",";
            if (trim($params->get('rewind'))) echo "rewind:" . $params->get('rewind') . ",";
            if ($params->get('autoplay')) {
                if (trim($params->get('autoplay'))) echo "autoplay:" . $params->get('autoplay') . ",";
                if (trim($params->get('autoplayHoverPause'))) echo "autoplayHoverPause:" . $params->get('autoplayHoverPause') . ",";
                if (trim($params->get('autoplaySpeed'))) echo "autoplaySpeed:" . $params->get('autoplaySpeed') . ",";
            } ?>
            responsive: responsive
        })

        function getUsefullJSON(params) {
            let obj = "{";

            for (let i = 0; i < params.breakpoint.length; i++) {
                obj += "\"" + params.breakpoint[i] + "\" : {\"items\": " + "\"" + params.items[i] + "\"" + "}";

                if (i < params.breakpoint.length - 1) {
                    obj += ",";
                }
            }

            obj += "}";

            return obj;

        }
    </script>

<?php endif;?>