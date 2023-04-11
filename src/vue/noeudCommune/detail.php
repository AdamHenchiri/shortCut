
<div class="menu-commune">
    <h1 class="titre">GID</h1>
    <h1 class="titre">Id de la route</h1>
    <h1 class="titre">Nom de la commune</h1>
    <h1 class="titre"><a href=\"?action=afficherDetail&controleur=noeudCommune&gid=<?=$noeudCommune->getGid()?>\">(Détail)</a></h1>
</div>
<div class="data-commune">
        <p><I><?= $noeudCommune->getGid() ?></I></p>
        <p><I><?= $noeudCommune->getId_rte500() ?></I></p>
        <p><I><?= $noeudCommune->getNomCommune() ?></I></p>
    <p><a class="hidden" href="/action/afficherDetail/<?=$noeudCommune->getGid()?>">(Détail)</a></p>
</div>
