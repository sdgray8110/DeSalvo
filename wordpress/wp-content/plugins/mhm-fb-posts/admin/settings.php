<?php $fb_info = new fb_posts(); ?>
<link rel="stylesheet" type="text/css" href="<?=$fb_info->adminStylesheet;?>">

<div class="wrap">
    <h2>Facebook Feeds</h2>

    <div class="feeds postbox stuffbox" id="fbFeeds">
        <h3 class="hndle">Feeds</h3>

        <div id="feedTableContainer"></div>

        <div id="feedFormContainer"></div>

        <table style="width:100%; border-top: 1px solid #d1d1d1; background: #fff;;">
            <tr data-feedname="" data-fbuserid="" data-fbappid="" data-fbsecret="" data-fblimit="">
                <td style="padding: 8px;"><a class="button-secondary action submit addAnother">Add Feed</a></td>
            </tr>
        </table>
    </div>
</div>

<var class="hidden" id="pageData"><?=json_encode($fb_info->pageData());?></var>

<?=$fb_info->get_template('feedTable');?>
<?=$fb_info->get_template('feedForm');?>
<?=$fb_info->get_template('recentPost');?>
<?=$fb_info->get_template('facebookError');?>

<script src="<?=$fb_info->templateJS;?>"></script>
<script src="<?=$fb_info->globalJS;?>"></script>
<script src="<?=$fb_info->adminJS;?>"></script>
<script src="<?=$fb_info->validationJS;?>"></script>
