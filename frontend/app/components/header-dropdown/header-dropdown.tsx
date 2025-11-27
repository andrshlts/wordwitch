import type { ReactNode } from 'react';
import { useState, useRef, useEffect } from 'react';
import clsx from 'clsx';

interface HeaderDropdownItem {
    href?: string;
    title?: string;
    content: ReactNode;
    onClick?: () => void;
};

interface HeaderDropdownProps {
    title: string;
    className?: string;
    trigger: ReactNode;
    triggerText: string;
    triggerClassName?: string;
    items: HeaderDropdownItem[];
    itemClassName?: string;
};

export default function HeaderDropdown({
    title,
    className,
    trigger,
    triggerText,
    triggerClassName,
    items,
    itemClassName,
}: HeaderDropdownProps) {
    const [isOpen, setOpen] = useState(false);
    const dropdownRef = useRef<HTMLDivElement>(null);

    const toggleDropdown = () => setOpen(prev => !prev);

    useEffect(() => {
        const handleOutsideClick = (e: MouseEvent) => {
            if (dropdownRef.current && !dropdownRef.current.contains(e.target as Node)) {
                setOpen(false);
            }
        };

        const handleEscape = (e: KeyboardEvent) => {
            if (isOpen && e.key === 'Escape') setOpen(false);
        };

        document.addEventListener('click', handleOutsideClick);
        document.addEventListener('keydown', handleEscape);

        return () => {
            document.removeEventListener('click', handleOutsideClick);
            document.removeEventListener('keydown', handleEscape);
        }
    }, []);

    return (
        <div className={clsx("relative inline-block", className)} ref={dropdownRef}>
            <button
                className={clsx(
                    "flex items-center justify-start gap-3",
                    "whitespace-nowrap px-4 h-12 w-full overflow-hidden",
                    "hover:opacity-80 transition-opacity duration-200",
                    "cursor-pointer bg-none",
                    "md:h-6 md:w-6 md:justify-center md:p-0",
                    triggerClassName
                )}
                onClick={toggleDropdown}
                aria-haspopup="menu"
                aria-expanded={isOpen}
                aria-label={title}
                title={title}
            >
                {trigger}
                <span className="md:hidden">{triggerText}</span>
            </button>
            <div
                role="menu"
                className={clsx(
                    "flex flex-col absolute top-full mt-6 right-0 p-2",
                    "w-max max-w-120 bg-violet-700 z-50",
                    "rounded-md shadow-lg/30 transition-all duration-200",
                    "sm:left-1/2 sm:right-auto sm:-translate-x-1/2",
                    { "opacity-0 pointer-events-none -translate-y-4": !isOpen },
                    { "opacity-100 pointer-events-auto translate-y-0": isOpen }
                )}
            >
                {items.map((item, idx) => {
                    if (item.href) {
                        return (
                            <a
                                key={idx}
                                href={item.href}
                                title={item.title}
                                role="menuitem"
                                className={clsx(
                                    "flex items-center gap-2 px-7 py-2",
                                    "text-sm font-medium text-gray-100",
                                    "hover:opacity-80 transition-opacity duration-200",
                                    itemClassName
                                )}
                                onClick={() => setOpen(false)}
                            >
                                {item.content}
                            </a>
                        );
                    }

                    return (
                        <button
                            key={idx}
                            type="button"
                            role="menuitem"
                            title={item.title}
                            className={clsx(
                                "flex items-center gap-2 px-7 py-2 w-full text-left",
                                "text-sm font-medium text-gray-100",
                                "cursor-pointer",
                                "hover:opacity-80 transition-opacity duration-200",
                                itemClassName
                            )}
                            onClick={() => {
                                item.onClick?.();
                                setOpen(false);
                            }}
                        >
                            {item.content}
                        </button>
                    );
                })}
            </div>
        </div>
    );
}