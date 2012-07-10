<?php

/**
 * @package Minecraft OnlineUsers Widget
 * @version 1.1
 */
/*
Plugin Name: Minecraft OnlineUsers Widget
Plugin URI: 
Description: Plugin Widget permettant d'afficher les joueurs en ligne d'un serveur dans le menu du blog.
Author: pirmax
Version: 1.1
Author URI: http://www.devence.com/
*/

require_once(dirname(__FILE__) . '/MinecraftQuery.class.php');

function widget_mou()
{
	register_widget("widget_mou");
}

add_action('widgets_init', 'widget_mou');

class widget_mou extends WP_widget
{

	function widget_mou(){
		$options = array(
			"classname" => "widget-mou",
			"description" => "Afficher les joueurs en ligne sur votre serveur Minecraft."
		);

		$this->WP_widget("widget-mou", "Minecraft OnlineUsers", $options);
	}

	function widget($args, $instance)
	{

		$defaut = array(
			"title" => "Les joueurs en ligne",
			"serverip" => "",
			"serverport" => "25565",
			"displayAvatar" => 1,
			"displayCount" => 1,
			"nbSlot" => 30,
			"format_data" => ""
		);
		$instance = wp_parse_args($instance, $defaut);

		if(empty($instance['serverip']) OR empty($instance['serverport']))
		{
		}
		else
		{

			$Query = new MinecraftQuery( );

			try
			{
				$Query->Connect( $instance['serverip'], $instance['serverport'], 1 );
				$GetPlayers = $Query->GetPlayers();
			}
			catch( MinecraftQueryException $e )
			{
				// echo $e->getMessage();
			}

			$displayWidget = '';

			extract($args);

			if($GetPlayers !== false)
			{
				$displayWidget .= '<ul id="playerList">';
				foreach ($GetPlayers as $i => $value)
				{
					if($instance['displayAvatar'] !== 1)
					{
						$displayWidget .= '<li style="font-size: 15px;"><img src="' . plugin_dir_url( __FILE__ ) . 'DisplayFace_player.php?pseudo=' . $value . '&size=25" width="25" height="25" border="0" title="" alt="" style="vertical-align: middle;" /> <strong>' . $value . '</strong></li>';
					}
					else
					{
						$displayWidget .= '<li style="font-size: 15px;"><strong>' . $value . '</strong></li>';
					}
				}
				$displayWidget .= '</ul>';
				$resnbPlayer = count($GetPlayers);
			}
			else
			{
				$displayWidget .= '<ul id="playerList">';
				$displayWidget .= '<li>Aucun joueur en ligne</li>';
				$displayWidget .= '</ul>';
				$resnbPlayer = 0;
			}

			echo $before_widget;

			if($instance['displayCount'] !== 1)
			{
				echo $before_title . $instance['title'] . '<strong style="margin-left: 20px;">' . $resnbPlayer . '/' . $instance['nbSlot'] . '</strong>' . $after_title;
			}
			else
			{
				echo $before_title . $instance['title'] . $after_title;
			}

			echo $displayWidget;
			echo $after_widget;

		}

	}

	function update($new, $old)
	{
		return $new;
	}

	function form($d)
	{

		$defaut = array(
			"title" => "Les joueurs en ligne",
			"serverip" => "",
			"serverport" => "25565",
			"displayAvatar" => 1,
			"displayCount" => 1,
			"nbSlot" => 30,
			"format_data" => ""
		);
		$d = wp_parse_args($d, $defaut);

		?>
		<p style="border-bottom: 1px dashed #CCCCCC; padding-bottom: 5px;">
		Pour activer le widget, vous devez activer <code>enable-query</code> (<b>enable-query=true</b>) dans le fichier <code>server.properties</code> de votre serveur CraftBukkit puis red&eacute;marrer votre serveur.
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>">Titre du widget :</label><br />
		<input value="<?php echo $d['title']; ?>" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" type="text" size="100%" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('serverip'); ?>">Adresse IP du serveur :</label><br />
		<input value="<?php echo $d['serverip']; ?>" name="<?php echo $this->get_field_name('serverip'); ?>" id="<?php echo $this->get_field_id('serverip'); ?>" type="text" size="100%" /><br />
		<label for="<?php echo $this->get_field_id('serverport'); ?>">Port du serveur :</label><br />
		<input value="<?php echo $d['serverport']; ?>" name="<?php echo $this->get_field_name('serverport'); ?>" id="<?php echo $this->get_field_id('serverport'); ?>" type="text" size="100%" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('nbSlot'); ?>">Nombre de slot du serveur :</label><br />
		<input value="<?php echo $d['nbSlot']; ?>" name="<?php echo $this->get_field_name('nbSlot'); ?>" id="<?php echo $this->get_field_id('nbSlot'); ?>" type="text" size="100%" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('displayAvatar'); ?>"><input name="<?php echo $this->get_field_name('displayAvatar'); ?>" id="<?php echo $this->get_field_id('displayAvatar'); ?>" type="checkbox" <?php if($d['displayAvatar'] !== 1){ echo 'checked'; } ?> /> Afficher les avatars</label><br />
		<label for="<?php echo $this->get_field_id('displayCount'); ?>"><input name="<?php echo $this->get_field_name('displayCount'); ?>" id="<?php echo $this->get_field_id('displayCount'); ?>" type="checkbox" <?php if($d['displayCount'] !== 1){ echo 'checked'; } ?> /> Afficher le nombre de joueur en ligne</label>
		</p>
		<?php

	}

}

?>