import { InputHTMLAttributes } from 'react';

export default function CsrfInput({
    className = '',
    ...props
}: InputHTMLAttributes<HTMLInputElement>) {
    const csrf_token = document.querySelector('meta[name="csrf-header"]').getAttribute('content')
    const csrf_value = document.querySelector('meta[name="csrf-value"]').getAttribute('content')
    return (
        <input
            {...props}
            type="hidden"
            name={csrf_token}
            value={csrf_value}
        />
    );
}
