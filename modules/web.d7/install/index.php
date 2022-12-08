<?

\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

if (class_exists("web_d7")) return;

Class web_d7 extends CModule
{
    public $MODULE_ID = "web.d7";
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $PARTNER_NAME;
    public $PARTNER_URI;
    public $errors;

    protected $moduleInstallPath;
    protected $bitrixAdminPath;

    public function __construct()
    {
        $arModuleVersion = [];

        include(__DIR__ . '/version.php');

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_NAME = "Тестовое задание";
        $this->MODULE_DESCRIPTION = "Практическое задание";

        $this->PARTNER_NAME = 'Alex';
        $this->PARTNER_URI = 'https://bitrix.webexpensive.ru/';

        $this->moduleInstallPath = $_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $this->MODULE_ID . '/install';
        $this->bitrixPath = $_SERVER['DOCUMENT_ROOT'] . '/bitrix';
    }

    public function DoInstall()
    {
        $this->InstallDB();
        $this->InstallFiles();
        RegisterModule($this->MODULE_ID);
        return true;
    }

    public function DoUninstall()
    {
        $this->UnInstallDB();
        $this->UnInstallFiles();
        UnRegisterModule($this->MODULE_ID);
        return true;
    }

    public function InstallDB()
    {
        /*global $DB;
        $this->errors = false;
        $this->errors = $DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . "/local/modules/web.d7/install/db/install.sql");
        if (!$this->errors) {
            return true;
        } else
            return $this->errors;
        */
        return true;
    }

    public function UnInstallDB()
    {
        /*global $DB;
        $this->errors = false;
        $this->errors = $DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . "/local/modules/web.d7/install/db/uninstall.sql");
        if (!$this->errors) {
            return true;
        } else
            return $this->errors;
        */
        return true;
    }

    protected function GetInstallFiles()
    {
        return array(
            '/admin' => '/admin'
        );
    }

    public function InstallFiles()
    {

        foreach ($this->GetInstallFiles() as $source => $destination)
        {
            CopyDirFiles($this->moduleInstallPath . $source, $this->bitrixPath . $destination, true, true);
            echo $this->moduleInstallPath . $source;
            echo '5555';
            echo $this->bitrixPath . $destination;
        }

        return true;
    }

    public function UnInstallFiles()
    {
        foreach ($this->GetInstallFiles() as $source => $destination)
        {

            if (is_dir($this->moduleInstallPath . $source))
            {
                $d = dir($this->moduleInstallPath . $source);

                while ($entry = $d->read())
                {
                    if ($entry == '.' || $entry == '..')
                    {
                        continue;
                    }

                    if (is_dir($this->bitrixPath . $destination . '/' . $entry))
                    {
                        DeleteDirFilesEx('bitrix' . $destination . '/' . $entry);
                    }
                    elseif (is_file($this->bitrixPath . $destination . '/' . $entry))
                    {
                        @unlink($this->bitrixPath . $destination . '/' . $entry);
                    }
                }
                $d->close();
            }

        }

        return true;
    }
}