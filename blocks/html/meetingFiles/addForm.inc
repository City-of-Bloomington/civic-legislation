<?php
/**
 * @copyright 2017-2020 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 * @param string    $this->type
 * @param Committee $this->committee
 * @param string    $this->eventId
 * @param DateTime  $this->date
 */
use Web\Url;
?>
<form method="post" enctype="multipart/form-data">
    <fieldset>
        <input name="committee_id" type="hidden" value="<?= $this->committee->getId(); ?>" />
        <input name="eventId"      type="hidden" value="<?= $this->eventId; ?>" />
        <input name="meetingDate"  type="hidden" value="<?= $this->date->format(DATE_FORMAT); ?>" />
        <input name="type"         type="hidden" value="<?= $this->type; ?>" />
        <input name="return_url"   type="hidden" value="<?= Url::current_url(BASE_HOST); ?>" />
        <input name="meetingFile"  type="file" />
        <button type="submit" class="upload"><?= $this->_('upload'); ?></button>
    </fieldset>
</form>
