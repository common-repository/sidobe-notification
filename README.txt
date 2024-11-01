=== Sidobe WP Notification ===
Contributors: sidobewp
Donate link: https://sidobe.com/contact
Tags: notifications, whatsapp, woocommerce
Requires at least: 5.8
Tested up to: 6.6
Stable tag: 1.0.1
Requires PHP: 7.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Send automatic WhatsApp notifications for WooCommerce orders. Keep your customers informed about their order status with real-time updates.

== Description ==

*Sidobe WP Notif: Free WhatsApp Notifications for WooCommerce orders*

[English]
This plugin can send notifications to your customers' WhatsApp numbers when there is a change in the order status, such as when the order status changes to shipped, processed, or other statuses. You can also customize the notification messages according to your preference for each type of order status.

You can also use your personal WhatsApp number as the message sender. First, register a Sidobe account and add your WhatsApp number to send messages. After that, you will receive a secret key that will be used by this plugin. For more details, see [Sidobe Plugin Wordpress Notification](https://sidobe.com/plugin-wordpress-notification/).

Don't worry, this plugin and service are free.

[Indonesia]
Plugin ini dapat mengirim notifikasi ke nomor whatsapp pelanggan anda ketika ada perubahan status pada pesanan, misalnya pesanan berubah
ke pengiriman, diproses atau status lainnya. Anda juga bisa mengubah pesan notifikasi sesuai dengan keinginan anda untuk setiap tipe status pesanan.

Anda juga bisa menggunakan nomor whatsapp pribadi anda sebagai pengirim pesan. Daftar akun Sidobe terlebih dahulu dan tambahkan nomor whatsapp
untuk mengirim pesan, setelah itu anda akan mendapatkan secret key yang nanti digunakan oleh plugin ini, simak lebih detail di [Sidobe Plugin Wordpress Notification](https://sidobe.com/plugin-wordpress-notification/)

Jangan khawatir, plugin dan layanan ini gratis.

== Third-Party or External Services ==

* Service Name: Sidobe WhatsApp API (https://sidobe.com/whatsapp-api/)
    * Description: This plugin uses our WhatsApp API (https://api.sidobe.com/wa/v1) to send WhatsApp notifications to your customers.
    * Data Collected: The plugin sends the destination phone number and message to send a WhatsApp message, but we do not collect your messages.
    * Privacy: Please review our Privacy Policy at this URL https://sidobe.com/privacy-policy/.
    * API Keys: You will need to obtain an API key from Sidobe Console (https://console.sidobe.com). Enter this key in the plugin settings.
    * Cost: Sidobe WhatsApp API offers both free and paid plans. Check our [pricing](https://sidobe.com/whatsapp-api/) for more details.

== Installation ==

1. Unzip the archive on your computer
2. Upload `sidobe-wp-notif` to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Go to `Sidobe Notif` -> `Options` and set `Secret Key` from Console Sidobe, if don't have please register on [Sidobe](https://sidobe.com)
5. Go to `Sidobe Notif` -> `General` to edit template notification

== Frequently Asked Questions ==

= Whose WhatsApp number or account will you use later? =

You can use your personal WhatsApp number or WhatsApp Business as the message sender.

= Is this Free WhatsApp API Service official from WhatsApp? =

No, we do not officially collaborate with WhatsApp to connect our system with them.

= Is there a possibility that my WhatsApp account could be blocked (banned)? =

Anyone who violates WhatsApp's rules or guidelines will have the potential to be blocked. For example, sending massive messages will be considered spam, sending messages that contain unlawful content (gambling, sex, pornography) and reports from many users will cause your WhatsApp account to be blocked.

= Where can I get the Secret Key? =

Please visit the website [Sidobe](https://sidobe.com) and register an account. Once successful and enter [Console](https://console.sidobe.com), please go to the `Developer Tools -> Credential` menu and you will find a button to see your `Secret Key`.

= Is this service free? =

Yes, we provide a free version of this service.

If you are still experiencing difficulties or problems, please contact us via email help@sidobe.com or visit the free version of the [Contact Us] (https://sidobe.com/contact) site.

== Screenshots ==

1. Create your message template according to the order status conditions
2. Create a message template and combine it with the shortcodes that we have provided
3. Enter your secret key and the plugin is ready to use

== Changelog ==

= 1.0.1 =

Release date: 2024-09-11

* Changed: Add wp_unslash before sanitize
* Fixed: Issue when template content is null
* Adds: Information about 3rd-party or external service in README
* Changed: Change function name with unique prefix (sidobe_wp_notif)
* Changed: Add prevent direct file access
* Changed: Text domain to sidobe-notification
* Adds: Composer files
* Fixed: Permission access template content

= 1.0.0 =
* First release to public
