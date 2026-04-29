<?php
/**
 * Spells
 *
 * @package   MyAAC
 * @author    Gesior <jerzyskalski@wp.pl>
 * @author    Slawkens <slawkens@gmail.com>
 * @copyright 2019 MyAAC
 * @link      https://my-aac.org
 */

use MyAAC\Models\Spell;

defined('MYAAC') or die('Direct access not allowed!');
$title = 'Magias';

if(isset($_REQUEST['vocation_id'])) {
	$vocation_id = $_REQUEST['vocation_id'];
	if($vocation_id == 'all') {
		$vocation = 'all';
	}
	else {
		$vocation = $config['vocations'][$vocation_id];
	}
}
else {
	$vocation = (isset($_REQUEST['vocation']) ? urldecode($_REQUEST['vocation']) : 'all');

	if($vocation == 'all') {
		$vocation_id = 'all';
	}
	else {
		$vocation_ids = array_flip($config['vocations']);
		$vocation_id = $vocation_ids[$vocation];
	}
}

$order = 'name';
$spells = array();
$spells_db = Spell::where('hide', '!=', 1)->where('type', '<', 4)->orderBy($order)->get();

if((string)$vocation_id != 'all') {
	foreach($spells_db as $spell) {
		$spell_vocations = json_decode($spell['vocations'], true);
		if(in_array($vocation_id, $spell_vocations) || count($spell_vocations) == 0) {
			$spell['vocations'] = null;
			$spells[] = $spell;
		}
	}
}
else {
	foreach($spells_db as $spell) {
		$vocations = json_decode($spell['vocations'], true);

		foreach($vocations as &$tmp_vocation) {
			if(isset($config['vocations'][$tmp_vocation]))
				$tmp_vocation = $config['vocations'][$tmp_vocation];
			else
				$tmp_vocation = 'Unknown';
		}

		$spell['vocations'] = implode('<br/>', $vocations);
		$spells[] = $spell;
	}
}

?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>tools/css/datatables.min.css">
<?php
$twig->display('spells.html.twig', array(
	'post_vocation_id' => $vocation_id,
	'post_vocation' => $vocation,
	'spells' => $spells,
	'item_path' => setting('core.item_images_url'),
));
?>

<script>
	$(document).ready( function () {
		var langPt = {
			"sEmptyTable": "Nenhum registro encontrado",
			"sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
			"sInfoFiltered": "(Filtrados de _MAX_ registros)",
			"sLengthMenu": "Mostrar _MENU_",
			"sLoadingRecords": "Carregando...",
			"sProcessing": "Processando...",
			"sSearch": "Buscar:",
			"sZeroRecords": "Nenhum resultado encontrado",
			"oPaginate": {
				"sFirst": "Primeiro",
				"sLast": "Último",
				"sNext": "Próximo",
				"sPrevious": "Anterior"
			}
		};
		$("#tb_instantSpells").DataTable({ language: langPt });
		$("#tb_conjureSpells").DataTable({ language: langPt });
		$("#tb_runeSpells").DataTable({ language: langPt });
	} );

</script>
<script src="<?php echo BASE_URL; ?>tools/js/datatables.min.js"></script>
