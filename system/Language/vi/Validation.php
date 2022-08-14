<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// Validation language settings
return [
    // Core Messages
    'noRuleSets'      => 'Không có quy tắc nào được chỉ định trong cấu hình Xác thực.',
    'ruleNotFound'    => '{0} không phải là một quy tắc hợp lệ.',
    'groupNotFound'   => '{0} không phải là một nhóm quy tắc xác nhận.',
    'groupNotArray'   => '{0} nhóm quy tắc phải là một mảng.',
    'invalidTemplate' => '{0} không phải là mẫu Xác thực hợp lệ.',

    // Rule Messages
    'alpha'                 => '{field} chỉ có thể chứa các ký tự chữ cái.',
    'alpha_dash'            => '{field} chỉ có thể chứa các ký tự chữ và số, gạch dưới và dấu gạch ngang.',
    'alpha_numeric'         => '{field} chỉ có thể chứa các ký tự chữ và số.',
    'alpha_numeric_punct'   => '{field} chỉ có thể chứa các ký tự chữ và số, dấu cách và ký tự ~! # $% & * - _ + = | :. ',
    'alpha_numeric_space'   => '{field} chỉ có thể chứa các ký tự chữ và số.',
    'alpha_space'           => '{field} chỉ có thể chứa các ký tự chữ cái and spaces.',
    'decimal'               => '{field} phải chứa một số thập phân.',
    'differs'               => '{field} phải khác với {param}.',
    'equals'                => '{field} phải chính xác: {param}.',
    'exact_length'          => '{field} phải có độ dài chính xác {param} ký tự.',
    'greater_than'          => '{field} phải chứa một số lớn hơn {param}.',
    'greater_than_equal_to' => '{field} phải chứa một số lớn hơn hoặc bằng {param}.',
    'hex'                   => '{field} chỉ có thể chứa các ký tự thập lục phân.',
    'in_list'               => '{field} phải là một trong: {param}.',
    'integer'               => '{field} phải chứa một số nguyên.',
    'is_natural'            => '{field} chỉ được chứa các chữ số.',
    'is_natural_no_zero'    => '{field} chỉ được chứa các chữ số và phải lớn hơn 0.',
    'is_not_unique'         => '{field} phải chứa một giá trị hiện có trước đó trong cơ sở dữ liệu.',
    'is_unique'             => '{field} phải chứa một giá trị duy nhất.',
    'less_than'             => '{field} phải chứa một số nhỏ hơn {param}.',
    'less_than_equal_to'    => '{field} phải chứa một số nhỏ hơn hoặc bằng {param}.',
    'matches'               => '{field} không khớp với {param}.',
    'max_length'            => '{field} không thể vượt quá {param} ký tự.',
    'min_length'            => '{field} phải có ít nhất {param} ký tự.',
    'not_equals'            => '{field} không thể là: {param}.',
    'numeric'               => '{field} chỉ được chứa số.',
    'regex_match'           => '{field} không đúng định dạng',
    'required'              => '{field} bắt buộc.',
    'required_with'         => '{field} bắt buộc khi {param} tồn tại.',
    'required_without'      => '{field} bắt buộc khi {param} không tồn tại.',
    'timezone'              => '{field} phải là múi giờ hợp lệ. ',
    'valid_base64'          => '{field} phải là một chuỗi base64 hợp lệ.',
    'valid_email'           => '{field} phải là địa chỉ email hợp lệ.',
    'valid_emails'          => '{field} phải chứa tất cả các địa chỉ email hợp lệ.',
    'valid_ip'              => '{field} phải là một địa chỉ IP hợp lệ.',
    'valid_url'             => '{field} phải là một đường dẫn URL hợp lệ.',
    'valid_date'            => '{field} phải là một ngày hợp lệ.',

    // Credit Cards
    'valid_cc_num' => '{field} dường như không phải là số thẻ tín dụng hợp lệ.',

    // Files
    'uploaded' => '{field} không phải là một tập tin tải lên hợp lệ.',
    'max_size' => '{field} tệp quá nặng.',
    'is_image' => '{field} không phải là một tập tin hình ảnh được tải lên hợp lệ.',
    'mime_in'  => '{field} phải là một tập tin có định dạng hợp lệ.',
    'ext_in'   => '{field} phải là phần mở rộng tập tin hợp lệ.',
    'max_dims' => '{field} không phải là một hình ảnh, hoặc nó quá rộng hoặc quá cao.',
];
