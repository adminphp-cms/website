<?php

namespace App\Navigation;

use Illuminate\Support\Collection;

/**
 * A link of the menu ready to render. Without href, it only opens its submenu.
 */
final readonly class MenuLink
{
    /**
     * @param  Collection<int, MenuLink>  $children
     */
    public function __construct(
        public string $title,
        public ?string $href,
        public bool $opensInNewTab,
        public Collection $children,
    ) {}

    /**
     * Whether the link leads to the page being shown.
     */
    public function isCurrent(): bool
    {
        return $this->href !== null && url()->current() === rtrim(url($this->href), '/');
    }

    /**
     * Whether the page being shown is this link or one of its submenu: highlights the parent.
     */
    public function isActive(): bool
    {
        return $this->isCurrent() || $this->children->contains(fn (MenuLink $child): bool => $child->isCurrent());
    }
}
