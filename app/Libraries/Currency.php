<?php namespace App\Libraries;

class Currency
{
    private array $currencies = [];

    public function __construct() {
        $currency_model = new \App\Modules\Currencies\Models\CurrencyModel();
        $this->currencies = $currency_model->getListPublished();
    }

    public function format(float $number, string $currency, float $value = 0, bool $format = true): string {
        if (!isset($this->currencies[$currency])) {
            return '';
        }

        $symbol_left   = $this->currencies[$currency]['symbol_left'];
        $symbol_right  = $this->currencies[$currency]['symbol_right'];
        $decimal_place = $this->currencies[$currency]['decimal_place'];

        if (!$value) {
            $value = $this->currencies[$currency]['value'];
        }

        $amount = $value ? (float)$number * $value : (float)$number;

        $amount = round($amount, $decimal_place);

        if (!$format) {
            return $amount;
        }

        $string = '';

        if ($symbol_left) {
            $string .= "<span>$symbol_left</span>";
        }

        $string .= number_format($amount, $decimal_place, lang('General.decimal_point'), lang('General.thousand_point'));

        if ($symbol_right) {
            $string .= "<span>$symbol_right</span>";
        }

        return $string;
    }

    public function convert(float $value, string $from, string $to): float {
        if (isset($this->currencies[$from])) {
            $from = $this->currencies[$from]['value'];
        } else {
            $from = 1;
        }

        if (isset($this->currencies[$to])) {
            $to = $this->currencies[$to]['value'];
        } else {
            $to = 1;
        }

        return $value * ($to / $from);
    }

    public function getId(string $currency): int {
        if (isset($this->currencies[$currency])) {
            return $this->currencies[$currency]['currency_id'];
        } else {
            return 0;
        }
    }

    public function getSymbolLeft(string $currency): string {
        if (isset($this->currencies[$currency])) {
            return $this->currencies[$currency]['symbol_left'];
        } else {
            return '';
        }
    }

    public function getSymbolRight(string $currency): string {
        if (isset($this->currencies[$currency])) {
            return $this->currencies[$currency]['symbol_right'];
        } else {
            return '';
        }
    }

    public function getDecimalPlace(string $currency): string {
        if (isset($this->currencies[$currency])) {
            return $this->currencies[$currency]['decimal_place'];
        } else {
            return 0;
        }
    }

    public function getValue(string $currency): float {
        if (isset($this->currencies[$currency])) {
            return $this->currencies[$currency]['value'];
        } else {
            return 0;
        }
    }

    public function has(string $currency): bool {
        return isset($this->currencies[$currency]);
    }
}
