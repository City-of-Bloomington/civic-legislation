<?php
/**
 * @copyright 2016-2020 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 * @param Applicant $this->applicant
 * @param boolean   $this->disableButtons
 */
use Application\Models\Person;

$name = self::escape("{$this->applicant->getFirstname()} {$this->applicant->getLastname()}");
?>
<section>
    <header>
        <h1><?= $name; ?></h1>
        <div class="tools">
        <?php
            if (!$this->disableButtons && Person::isAllowed('applicants', 'update')) {
                $helper = $this->template->getHelper('buttonLink');
                echo $helper->buttonLink(
                    parent::generateUri('applicants.update').'?applicant_id='.$this->applicant->getId(),
                    $this->_('applicant_edit'),
                    'edit'
                );
            }
        ?>
        </div>
    </header>

    <?php
        $fields = [
            'email', 'phone', 'address', 'city', 'zip',
            'citylimits', 'occupation', 'referredFrom', 'referredOther',
            'interest', 'qualifications'
        ];
        foreach ($fields as $f) {
            $get = 'get'.ucfirst($f);
            switch ($f) {
                case 'citylimits':
                    $$f = $this->applicant->getCitylimits() ? $this->_('yes') : $this->_('no');
                    break;
                default:
                    $$f = self::escape($this->applicant->$get());
            }

            echo "
            <dl>
                <dt>{$this->_($f)}</dt>
                <dd>{$$f}</dd>
            </dl>
            ";
        }
        if (Person::isAllowed('applicantFiles', 'download')) {
            echo "
            <dl>
                <dt>{$this->_('applicantFile')}</dt><dd>
            ";
                $files = $this->applicant->getFiles();
                $uri   = parent::generateUri('applicantFiles.download');
                foreach ($files as $f) {
                    $filename = self::escape($f->getFilename());
                    echo "<a href=\"$uri?applicantFile_id={$f->getId()}\" class=\"{$f->getMime_type()}\">$filename</a>";
                }
            echo "
                </dd>
            </dl>
            ";
        }
    ?>
</section>
