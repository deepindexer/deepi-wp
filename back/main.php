<?php


function deepi_main_html() {
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    global $wpdb;
?>
<div class="wrap">
    <h1 id="description"><?php _e("Deepi WordPress Plugin",'deepi'); ?></h1>
<p><?php _e("Let Deepi do your site's search",'deepi'); ?></p>
<p><?php _e("Upgrade your site's \"lexical search\" to Deepi's \"Conceptual Search\"","deepi"); ?></p>
<p><?php _e("Take advantage of the latest \"artificial intelligence\" technologies",'deepi'); ?></p>
<p><?php _e("<strong>Note</strong>: The \"beta version\" can only be used through \"Iranian payment gateways\".",'deepi'); ?></p>
<h1 id="features"><?php _e("Features",'deepi'); ?></h1>
<ul>
<li>* <?php _e("Conceptual search service",'deepi'); ?></li>
<li>* <?php _e("Conceptual search of sentences",'deepi'); ?></li>
<li>* <?php _e("Conceptual search in seventy different languages",'deepi'); ?></li>
<li>* <?php _e("Conceptual recommendation service",'deepi'); ?></li>
<li>* <?php _e("Intelligent NER (Named Entity Recognition)",'deepi'); ?></li>
<li>* <?php _e("Precise &amp; quick",'deepi'); ?></li>
</ul>
<p><?php _e('This plugin requires API keys from <a href="http://www.deepi.ir">Deepi</a>.','deepi'); ?></p>
<h1 id="getting-started"><?php _e("Getting Started",'deepi'); ?></h1>
<p><?php _e("A guide to setting up the WP Search with the Deepi plugin.",'deepi'); ?></p>
<h2 id="deepi-credentials"><?php _e("Deepi Credentials",'deepi'); ?></h2>
<p><?php _e("When logged into the WordPress Dashboard, find the &quot;Deepi&quot; entry in the left-hand admin menu and
click on it. You will be presented with the Settings page where you configure your Deepi credentials.",'deepi'); ?></p>
<p><?php _e('If you do not have a Deepi account yet, you can create one for free at <a href="http://www.deepi.ir">Deepi</a>.
Once you have created your account, and you have signed in,','deepi'); ?></p>
<ol>
<li><?php _e('Go to the <a href="http://www.deepi.ir/dashboard/setting/">setting page</a>.','deepi'); ?></li>
<li><?php _e("Create a new project for your first website (Figure 1).",'deepi'); ?></li>

<p><img src="<?php echo deepi__PLUGIN_URL."resources/img/project.png";?>" alt="Deepi Setting Page &gt; Create New Project"></p>

<li><?php _e("you will need to copy/paste the following keys to your WordPress setting form (Figure 2):",'deepi'); ?>
    <p><img src="<?php echo deepi__PLUGIN_URL."resources/img/keys.png";?>" style="max-width: 100%; height: auto;"></p>
    <ul>
        <li>* <?php _e("Project Slug",'deepi'); ?></li>
        <li>* <?php _e("API Key",'deepi'); ?></li>
    </ul>
    <p><?php _e("<strong>Note</strong>: Copy/pasting these keys manually; is very error-prone. The copy button on the right side of each key will make copy/pasting easier.",'deepi'); ?></p>
    <p><?php _e("Once you have filled in the required keys on the WordPress settings form, click on the Save Changes button at the bottom of the form.",'deepi'); ?></p>
    <p><?php _e("If you have correctly provided WordPress with your Deepi keys, you will see a success message.",'deepi'); ?></p>
</li>

<li>
    <p><?php _e("If your Deepi account credit is positive, the WordPress setting page status switches to &quot;active&quot;.",'deepi'); ?></p>
</li>
<li>
    <p><?php _e("Click on the &quot;Index&quot; button to send your content to Deepi servers. After that, everything will be kept in sync
automatically.",'deepi'); ?></p>
</li>
</ol>

<br /><br />
<h2 id="-do-not-use-deepi"><?php _e("[ ] Do not use Deepi",'deepi'); ?></h2>
<p><?php _e("With this option, Deepi will not replace the native WordPress search experience. Deepi will
index the content, but it will not affect the native WordPress search page experience.",'deepi'); ?></p>
<p><?php _e("This option is useful when you only need Deepi Plugin to index your WordPress content. For example, if you
intend to",'deepi'); ?></p>
<ul>
<li>* <?php _e("Make your content searchable from another site that implements Deepi",'deepi'); ?></li>
<li>* <?php _e("Build a custom search UI with your Deepi search bar implementation",'deepi'); ?></li>
</ul>
<br /><br />
<h2 id="-remove-deepi-powered-by-logo-link"><?php _e("[ ] Remove Deepi powered by logo link",'deepi'); ?></h2>
<p><?php _e("This will remove the Deepi logo &quot;link&quot; and only displays a pure logo image.",'deepi'); ?></p>
<br /><br />
<h2 id="-remove-deepi-version-link"><?php _e("[ ] Remove &quot;Deepi version&quot; link",'deepi'); ?></h2>
<p><?php _e("This will remove the &quot;Deepi version&quot; link at the end of each post. In this version, the named entities of
your text have been recognized quite intelligently and have become a searchable link.",'deepi'); ?></p>

	
<?php
echo "</div>";
}



