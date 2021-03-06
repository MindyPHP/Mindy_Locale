<?php

namespace Mindy\Locale\Loader;

use Mindy\Helper\Alias;
use ReflectionClass;

class PhpSourceLoader extends SourceLoader
{
    /**
     * @var string the base path for all translated messages. Defaults to null, meaning
     * the "messages" subdirectory of the application directory (e.g. "protected/messages").
     */
    public $basePath = null;
    /**
     * @var array
     */
    public $extensionPaths = [];
    /**
     * @var array
     */
    private $_files = [];

    /**
     * Initializes the application component.
     * This method overrides the parent implementation by preprocessing
     * the user request data.
     */
    public function init()
    {
        if ($this->basePath === null) {
            $this->basePath = __DIR__ . '/../messages';
        }
    }

    /**
     * Determines the message file name based on the given category and language.
     * If the category name contains a dot, it will be split into the module class name and the category name.
     * In this case, the message file will be assumed to be located within the 'messages' subdirectory of
     * the directory containing the module class file.
     * Otherwise, the message file is assumed to be under the {@link basePath}.
     * @param string $category category name
     * @param string $language language ID
     * @return string the message file path
     */
    protected function getMessageFile($category, $language)
    {
        if (!isset($this->_files[$category][$language])) {
            if (($pos = strpos($category, '.')) !== false) {
                $extensionClass = substr($category, 0, $pos);
                $extensionCategory = substr($category, $pos + 1);
                // First check if there's an extension registered for this class.
                if (isset($this->extensionPaths[$extensionClass])) {
                    $this->_files[$category][$language] = Alias::get($this->extensionPaths[$extensionClass]) . DIRECTORY_SEPARATOR . $language . DIRECTORY_SEPARATOR . $extensionCategory . '.php';
                } else {
                    // No extension registered, need to find it.
                    $class = new ReflectionClass($extensionClass);
                    $this->_files[$category][$language] = dirname($class->getFileName()) . DIRECTORY_SEPARATOR . 'messages' . DIRECTORY_SEPARATOR . $language . DIRECTORY_SEPARATOR . $extensionCategory . '.php';
                }
            } else {
                $this->_files[$category][$language] = $this->basePath . DIRECTORY_SEPARATOR . $language . DIRECTORY_SEPARATOR . $category . '.php';
            }
        }
        return $this->_files[$category][$language];
    }

    /**
     * Loads the message translation for the specified language and category.
     * @param string $category the message category
     * @param string $language the target language
     * @return array the loaded messages
     */
    public function loadMessages($category, $language)
    {
        $messageFile = $this->getMessageFile($category, $language);
        if (is_file($messageFile)) {
            $messages = include($messageFile);
            if (!is_array($messages)) {
                $messages = [];
            }
            return $messages;
        } else {
            return [];
        }
    }
}
