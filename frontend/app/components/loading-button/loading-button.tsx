import type { ButtonHTMLAttributes, ReactNode } from 'react';
import clsx from 'clsx';

interface LoadingButtonProps extends ButtonHTMLAttributes<HTMLButtonElement> {
    isLoading?: boolean;
    children: ReactNode;
}

export default function LoadingButton({
    isLoading = false,
    children,
    className,
    disabled,
    ...props
}: LoadingButtonProps) {
    return (
        <button
            {...props}
            disabled={isLoading || disabled}
            className={clsx(
                "relative px-8 py-2 inline-flex justify-center items-center",
                "rounded-md bg-violet-600 text-white disabled:opacity-80",
                "cursor-pointer hover:opacity-80 transition-opacity duration-200",
                className
            )}
        >
            <span className={isLoading ? "opacity-0" : "opacity-100"}>
                {children}
            </span>
            {isLoading && (
                <div className="
                    absolute inset-0 flex justify-center items-center
                    gap-1 animate-[pulse_1s_ease-in-out_infinite]
                ">
                    <div className="h-2 w-2 bg-gray-300 rounded-full"></div>
                    <div className="h-2.5 w-2.5 bg-gray-300 rounded-full"></div>
                    <div className="h-2 w-2 bg-gray-300 rounded-full"></div>
                </div>
            )}
        </button>
    );
}