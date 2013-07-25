<?php

/**
 * @package Minecraft Online Users Widget
 * @version 2.0
 */
/*
Plugin Name: Minecraft Online Users Widget
Plugin URI: 
Description: Plugin Widget permettant d'afficher les joueurs en ligne d'un serveur dans le menu du blog.
Author: pirmax
Version: 2.0
Author URI: http://pirmax.fr/
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
			"ifNoPlayer" => "Aucun joueur en ligne",
			"serverip" => "",
			"serverport" => "25565",
			"displayAvatar" => 1,
			"displayCount" => 1,
			"nbSlot" => 30,
			"avatarSize" => 25,
			"styleCSS" => "#mouw_li {
	font-size: 15px;
	font-weight: bold;
}

#mouw_li #mouw_avatar {
	vertical-align: middle;
	margin-right: 10px;
}

#mouw_title {
	
}

#mouw_number {
	margin-left: 20px;
	font-weight: bold;
}",
			"format_data" => ""
		);
		$instance = wp_parse_args($instance, $defaut);

		$GetPlayers = array();

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

			$displayWidget .= '<ul id="mouw_ul">';

			if($GetPlayers !== false)
			{
				foreach ($GetPlayers as $i => $value)
				{
					if($instance['displayAvatar'] !== 1)
					{
						$displayWidget .= '<li id="mouw_li"><img src="https://minotar.net/helm/' . $value . '/' . $instance['avatarSize'] . '.png" width="' . $instance['avatarSize'] . '" height="' . $instance['avatarSize'] . '" border="0" title="' . $value . '" alt="avatar_' . $value . '" id="mouw_avatar" />' . $value . '</li>';
					}
					else
					{
						$displayWidget .= '<li id="mouw_li">' . $value . '</li>';
					}
				}
				$resnbPlayer = count($GetPlayers);
			}
			else
			{
				$displayWidget .= '<li id="mouw_li">' . $instance['ifNoPlayer'] . '</li>';
				$resnbPlayer = 0;
			}

			$displayWidget .= '</ul>';

			echo $before_widget;

			if($instance['displayCount'] !== 1)
			{
				echo $before_title . '<span id="mouw_title">' . $instance['title'] . '</span><span id="mouw_number">' . $resnbPlayer . '/' . $instance['nbSlot'] . '</span>' . $after_title;
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
			"ifNoPlayer" => "Aucun joueur en ligne",
			"serverip" => "",
			"serverport" => "25565",
			"displayAvatar" => 1,
			"displayCount" => 1,
			"nbSlot" => 30,
			"avatarSize" => 25,
			"styleCSS" => "#mouw_li {
	font-size: 15px;
	font-weight: bold;
}

#mouw_li #mouw_avatar {
	vertical-align: middle;
	margin-right: 10px;
}

#mouw_title {
	
}

#mouw_number {
	margin-left: 20px;
	font-weight: bold;
}",
			"format_data" => ""
		);
		$d = wp_parse_args($d, $defaut);

		?>
		<?php if(!function_exists('fwrite')){ echo '<p style="border-bottom: 1px dashed #FF0000; color: #FF0000; padding-bottom: 5px;"><b>Attention!</b> La fonction PHP <code>fwrite()</code> n\'est pas disponible sur votre hébergement. Contactez votre administrateur système.</p>'; } ?>
		<p style="border-bottom: 1px dashed #CCCCCC; padding-bottom: 5px;">
		Pour activer le widget, vous devez activer <code>enable-query</code> (<b>enable-query=true</b>) dans le fichier <code>server.properties</code> de votre serveur CraftBukkit puis red&eacute;marrer votre serveur.
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>">Titre du widget :</label><br />
		<input value="<?php echo $d['title']; ?>" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" type="text" size="35" style="margin-left: 1em;" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('serverip'); ?>">Adresse IP du serveur :</label><br />
		<input value="<?php echo $d['serverip']; ?>" name="<?php echo $this->get_field_name('serverip'); ?>" id="<?php echo $this->get_field_id('serverip'); ?>" type="text" size="35" style="margin-left: 1em;" /><br />
		<label for="<?php echo $this->get_field_id('serverport'); ?>">Port du serveur :</label><br />
		<input value="<?php echo $d['serverport']; ?>" name="<?php echo $this->get_field_name('serverport'); ?>" id="<?php echo $this->get_field_id('serverport'); ?>" type="text" size="20" style="margin-left: 1em;" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('nbSlot'); ?>">Nombre de slot du serveur :</label><br />
		<input value="<?php echo $d['nbSlot']; ?>" name="<?php echo $this->get_field_name('nbSlot'); ?>" id="<?php echo $this->get_field_id('nbSlot'); ?>" type="text" size="10" style="margin-left: 1em;" /> slot(s)  <abbr title="Nombre de slot disponible sur votre serveur">(?)</abbr>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('avatarSize'); ?>">Taille des avatars :</label><br />
		<input value="<?php echo $d['avatarSize']; ?>" name="<?php echo $this->get_field_name('avatarSize'); ?>" id="<?php echo $this->get_field_id('avatarSize'); ?>" type="text" size="10" style="margin-left: 1em;" /> pixel(s)  <abbr title="Nombre de pixel (Longueur x Hauteur) de l'image">(?)</abbr>
		</p>
		<p id="editCSS">
		<label for="<?php echo $this->get_field_id('styleCSS'); ?>">Modifier le style CSS :</label><br />
		<textarea name="<?php echo $this->get_field_name('styleCSS'); ?>" id="<?php echo $this->get_field_id('styleCSS'); ?>" cols="36" rows="10"><?php echo $d['styleCSS']; ?></textarea>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('displayAvatar'); ?>"><input name="<?php echo $this->get_field_name('displayAvatar'); ?>" id="<?php echo $this->get_field_id('displayAvatar'); ?>" type="checkbox" <?php if($d['displayAvatar'] !== 1){ echo 'checked'; } ?> /> Afficher l'avatar des joueurs</label><br />
		<label for="<?php echo $this->get_field_id('displayCount'); ?>"><input name="<?php echo $this->get_field_name('displayCount'); ?>" id="<?php echo $this->get_field_id('displayCount'); ?>" type="checkbox" <?php if($d['displayCount'] !== 1){ echo 'checked'; } ?> /> Afficher le nombre de joueur en ligne</label>
		</p>
		<p style="border-bottom: 1px dashed #CCCCCC; padding-bottom: 5px;">
		Soutenez le créateur de cette extension en vous abonnant à sa chaîne : <a href="http://www.youtube.com/user/PirmaxLePoulpeRouge" target="_blank">PirmaxLePoulpeRouge</a>.
		</p>
		<?php

	}

}

?>