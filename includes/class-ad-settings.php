<?php

class adSettings
{
    /**
     * Initialise the filters and actions
     *
     */
    function run() {
        add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array($this, 'addSettingsLink') );
        add_action( 'admin_menu', array($this, 'addOptionsPage') );
        add_action( 'admin_init',  array($this, 'registerSettings') );
    }
    /**
     * Filter the plugin's action links to add our settings page.
     *
     * @since 0.0.1
     *
     * @param $links
     *
     * @return array
     */
    function addSettingsLink( $links ) {
        return array_merge( array( 'settings' => '<a href="' . admin_url( 'options-general.php?page=ns-ads.php' ) . '">' . __( 'Settings', 'ns-ads' ) . '</a>' ), $links );
    }
    /**
     * Add options page.
     *
     * @since 0.0.1
     */
    function addOptionsPage() {
        add_options_page( 'NS Ads Manager', 'NS Ads Manager', 'manage_options', 'ns-ads.php', array ($this, 'renderOptionsPage') );
    }
    /**
     * Register settings, sections, and fields.
     *
     * @since 0.0.1
     */
    function registerSettings() {
        register_setting( 'ns-ads', 'ns_ads_settings', array ($this, 'ns_ads_settings_sanitize_callback') );
        //Settings for Advertising
        add_settings_section( 'ns_ads_settings', __( 'Top and Bottom predefined ads', 'ns-ads' ), array ($this, 'DefaultAdsCallback'), 'ns-ads' );
        add_settings_field( 'ns_ads_settings_top_desktop', __( 'Top Ad (Desktop): ', 'ns-ads' ), array ($this, 'TopAdDesktopCallback'), 'ns-ads', 'ns_ads_settings' );
	    add_settings_field( 'ns_ads_settings_bottom_desktop', __( 'Bottom Ad (Desktop): ', 'ns-ads' ), array ($this, 'BottomAdDesktopCallback'), 'ns-ads', 'ns_ads_settings' );
	    add_settings_field( 'ns_ads_settings_top_amp', __( 'Top Ad (AMP): ', 'ns-ads' ), array ($this, 'TopAdAMPCallback'), 'ns-ads', 'ns_ads_settings' );
	    add_settings_field( 'ns_ads_settings_bottom_amp', __( 'Bottom Ad (AMP): ', 'ns-ads' ), array ($this, 'BottomAdAMPCallback'), 'ns-ads', 'ns_ads_settings' );
    }
    /**
     * Render options page.
     *
     * @since 0.0.1
     */
    function renderOptionsPage() {
        ?>
        <form action='options.php' method='post' enctype='multipart/form-data'>
            <?php
            settings_fields( 'ns-ads' );
            do_settings_sections( 'ns-ads' );
            submit_button();
            ?>
        </form>
        <?php
    }

    /**
     * Main section callback
     *
     * @since 0.0.1
     */
    function DefaultAdsCallback() {
    	echo '<p>Top ad will appear at the top of the article content, before the first paragraph</p>
	        <p>Bottom ad will appear right below the content, after the last paragraph</p>';
    }

    /**
     * Desktop ad, right below the article title.
     *
     */
    function TopAdDesktopCallback()
    {
        $options = get_option( 'ns_ads_settings' );
        ?>
	    <textarea rows="4" cols="50" name="ns_ads_settings[ns_ads_settings_top_desktop]"><?php echo $options['ns_ads_settings_top_desktop']; ?></textarea>
        <?php
    }
    /**
     * Desktop ad, right below the article last paragraph.
     *
     */
    function BottomAdDesktopCallback()
    {
        $options = get_option( 'ns_ads_settings' );
        ?>
	    <textarea rows="4" cols="50" name="ns_ads_settings[ns_ads_settings_bottom_desktop]"><?php echo $options['ns_ads_settings_bottom_desktop']; ?></textarea>
        <?php
    }
    /**
     * AMP only ad, right below the article title.
     *
     */
    function TopAdAMPCallback()
    {
        $options = get_option( 'ns_ads_settings' );
        ?>
	    <textarea rows="4" cols="50" name="ns_ads_settings[ns_ads_settings_top_amp]"><?php echo $options['ns_ads_settings_top_amp']; ?></textarea>
        <?php
    }

	/**
	 * AMP only ad, right below the article last paragraph.
	 */
	function BottomAdAMPCallback()
	{
		$options = get_option( 'ns_ads_settings' );
		?>
		<textarea rows="4" cols="50" name="ns_ads_settings[ns_ads_settings_bottom_amp]"><?php echo $options['ns_ads_settings_bottom_amp']; ?></textarea>
		<?php
	}

    /**
     * Sanitizes settings before they get to the database.
     *
     * @since 0.0.1
     *
     * @param $input array Options array.
     *
     * @return array Sanitized, database-ready options array.
     */
    function ns_ads_settings_sanitize_callback( $input ) {
        return $input;
    }
}