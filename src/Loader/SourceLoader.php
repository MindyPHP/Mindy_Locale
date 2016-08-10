<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 09/08/16
 * Time: 19:52
 */

namespace Mindy\Locale\Loader;

use Mindy\Helper\Traits\Accessors;
use Mindy\Helper\Traits\Configurator;
use Mindy\Locale\LocaleData;

abstract class SourceLoader
{
    use Configurator, Accessors;

    /**
     * @var \Mindy\Locale\Locale
     */
    public $translate;
    /**
     * @var boolean whether to force message translation when the source and target languages are the same.
     * Defaults to false, meaning translation is only performed when source and target languages are different.
     * @since 1.1.4
     */
    public $forceTranslation = false;

    private $_language;
    private $_messages = [];

    /**
     * Loads the message translation for the specified language and category.
     * @param string $category the message category
     * @param string $language the target language
     * @return array the loaded messages
     */
    abstract protected function loadMessages($category, $language);

    /**
     * @return string the language that the source messages are written in.
     * Defaults to {@link CApplication::language application language}.
     */
    public function getLanguage()
    {
        return $this->_language === null ? $this->getTranslate()->sourceLanguage : $this->_language;
    }

    /**
     * @param string $language the language that the source messages are written in.
     */
    public function setLanguage($language)
    {
        $this->_language = LocaleData::getCanonicalID($language);
    }

    /**
     * Translates a message to the specified language.
     *
     * Note, if the specified language is the same as
     * the {@link getLanguage source message language}, messages will NOT be translated.
     *
     * If the message is not found in the translations, an {@link onMissingTranslation}
     * event will be raised. Handlers can mark this message or do some
     * default handling. The {@link CMissingTranslationEvent::message}
     * property of the event parameter will be returned.
     *
     * @param string $category the message category
     * @param string $message the message to be translated
     * @param string $language the target language. If null (default), the {@link CApplication::getLanguage application language} will be used.
     * @return string the translated message (or the original message if translation is not needed)
     */
    public function t($category, $message, $language = null)
    {
        if ($language === null) {
            $language = $this->getTranslate()->getLanguage();
        }

        if ($this->forceTranslation || $language !== $this->getLanguage()) {
            return $this->translateMessage($category, $message, $language);
        } else {
            return $message;
        }
    }

    /**
     * @return \Mindy\Locale\Locale
     */
    protected function getTranslate()
    {
        return $this->translate;
    }

    /**
     * Translates the specified message.
     * If the message is not found, an {@link onMissingTranslation}
     * event will be raised.
     * @param string $category the category that the message belongs to
     * @param string $message the message to be translated
     * @param string $language the target language
     * @return string the translated message
     */
    protected function translateMessage($category, $message, $language)
    {
        $key = $language . '.' . $category;
        if (!isset($this->_messages[$key])) {
            $this->_messages[$key] = $this->loadMessages($category, $language);
        }

        if (isset($this->_messages[$key][$message]) && $this->_messages[$key][$message] !== '') {
            return $this->_messages[$key][$message];
        } else {
            // Mindy::app()->signal->send($this, 'missingTranslation', $this, $language, $message);
        }
        return $message;
    }

    /**
     * Raised when a message cannot be translated.
     * Handlers may log this message or do some default handling.
     * The {@link CMissingTranslationEvent::message} property
     * will be returned by {@link translateMessage}.
     * @param $owner SourceLoader
     * @param $language string
     * @param $message string
     */
    public function missingTranslation($owner, $language, $message)
    {

    }
}