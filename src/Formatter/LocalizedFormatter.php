<?php

namespace Mindy\Locale\Formatter;
use Mindy\Locale\LocaleData;

/**
 * CLocalizedFormatter provides a set of commonly used data formatting methods based on the current locale settings.
 *
 * It provides the same functionality as {@link CFormatter}, but overrides all the settings for
 * {@link booleanFormat}, {@link datetimeFormat} and {@link numberFormat} with the values for the
 * current locale. Because of this you are not able to configure these properties for CLocalizedFormatter directly.
 * Date and time format can be adjusted by setting {@link dateFormat} and {@link timeFormat}.
 *
 * It uses {@link CApplication::locale} by default but you can set a custom locale by using {@link setLocale}-method.
 *
 * For a list of recognizable format types, and details on how to call the formatter methods,
 * see {@link CFormatter} documentation.
 *
 * To replace the application component 'format', which is registered by {@link CApplication} by default, you can
 * put this in your application 'components' config:
 * <code>
 * 'format' => array(
 *     'class' => 'CLocalizedFormatter',
 * ),
 * </code>
 *
 * @author Carsten Brandt <mail@cebe.cc>
 * @package Mindy\Locale
 * @since 1.1.14
 */
class LocalizedFormatter extends Formatter
{
    /**
     * @var string the width of the date pattern. It can be 'full', 'long', 'medium' and 'short'. Defaults to 'medium'.
     * @see CDateFormatter::formatDateTime()
     */
    public $dateFormat = 'medium';
    /**
     * @var string the width of the time pattern. It can be 'full', 'long', 'medium' and 'short'. Defaults to 'medium'.
     * @see CDateFormatter::formatDateTime()
     */
    public $timeFormat = 'medium';

    /**
     * @return LocaleData $locale the locale currently used for formatting values
     */
    public function getLocaleData()
    {
        $localeData = $this->getTranslate()->getLocaleData();
        $this->sizeFormat['decimalSeparator'] = $localeData->getNumberSymbol('decimal');
        return $localeData;
    }

    /**
     * Formats the value as a boolean.
     * @param mixed $value the value to be formatted
     * @return string the formatted result
     * @see booleanFormat
     */
    public function formatBoolean($value)
    {
        return $value ? $this->t('base', 'Yes') : $this->t('base', 'No');
    }

    /**
     * Formats the value as a date using the {@link locale}s date formatter.
     * @param mixed $value the value to be formatted
     * @return string the formatted result
     * @see dateFormat
     * @see Locale::getDateFormatter()
     */
    public function formatDate($value)
    {
        return $this->getLocaleData()->getDateFormatter()->formatDateTime($this->normalizeDateValue($value), $this->dateFormat, null);
    }

    /**
     * Formats the value as a time using the {@link locale}s date formatter.
     * @param mixed $value the value to be formatted
     * @return string the formatted result
     * @see timeFormat
     * @see Locale::getDateFormatter()
     */
    public function formatTime($value)
    {
        return $this->getLocaleData()->dateFormatter->formatDateTime($this->normalizeDateValue($value), null, $this->timeFormat);
    }

    /**
     * Formats the value as a date and time using the {@link locale}s date formatter.
     * @param mixed $value the value to be formatted
     * @return string the formatted result
     * @see dateFormat
     * @see timeFormat
     * @see Locale::getDateFormatter()
     */
    public function formatDatetime($value)
    {
        return $this->getLocaleData()->getDateFormatter()->formatDateTime($this->normalizeDateValue($value), $this->dateFormat, $this->timeFormat);
    }

    /**
     * Formats the value as a number using the {@link locale}s number formatter.
     * @param mixed $value the value to be formatted
     * @return string the formatted result
     * @see Locale::getNumberFormatter()
     */
    public function formatNumber($value)
    {
        return $this->getLocaleData()->getNumberFormatter()->formatDecimal($value);
    }
}
