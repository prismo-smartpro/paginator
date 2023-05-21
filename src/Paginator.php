<?php

namespace SmartPRO\Technology;

class Paginator
{
    protected ?int $limite;
    protected ?int $page = 0;
    protected ?int $offset = 0;
    protected string $url;
    protected int $links;
    protected string $prev = "<i class='fa fa-angle-left'></i>";
    protected string $next = "<i class='fa fa-angle-right'></i>";
    protected ?string $range;

    public function __construct($project)
    {
        $this->setUrl($project);
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $this->page = (int)($page <= 1 ? 0 : ($page - 1));
    }

    public function create($rows, $limite)
    {
        $this->setLimite($limite);
        $links = ceil($rows / $limite);
        $this->setLinks($links);
        $offset = ($this->page * $this->limite);
        $this->setOffset($offset);
    }

    public function render($rang = 4): ?string
    {
        $this->setRange($rang);
        if ($this->links >= 2) {
            $page = max(filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT), 1);
            $next = min(($page + 1), $this->links);
            $disableNext = ($page >= $this->links ? "disabled" : "");
            $prev = max(($page - 1), 1);
            $disablePrev = ($page <= 1 ? "disabled" : "");
            $html = null;
            $html .= "<ul class='pagination'>";
            $html .= "<li class='page-item {$disablePrev}'>";
            $html .= "<a href='{$this->url}{$prev}' class='page-link'>";
            $html .= "{$this->prev}";
            $html .= "</a>";
            $html .= "</li>";
            $max = $rang;
            for ($i = max(1, $page - $rang); $i <= min($page + $rang, $this->links); $i++) {
                $active = ($i == ($this->page + 1) ? "active" : "");
                $html .= "<li class='page-item {$active}'>";
                $html .= "<a href='{$this->url}{$i}' class='page-link'>{$i}</a>";
                $html .= "</li>";
            }
            $html .= "<li class='page-item {$disableNext}'>";
            $html .= "<a href='{$this->url}{$next}' class='page-link'>";
            $html .= "{$this->next}";
            $html .= "</a></li></ul>";
            return $html;
        }
        return null;
    }

    public function currentPage(): string
    {
        return "Página " . ($this->page + 1) . " de {$this->links}";
    }

    private function setLinks(int $links): void
    {
        $this->links = $links;
    }

    private function setOffset(?int $offset): void
    {
        $this->offset = $offset;
    }

    private function setLimite(?int $limite): void
    {
        $this->limite = $limite;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function limite(): ?int
    {
        return $this->limite;
    }

    public function offset(): ?int
    {
        return $this->offset;
    }

    public function setNext(string $next): void
    {
        $this->next = $next;
    }

    public function setRange(?string $range): void
    {
        $this->range = $range;
    }

    public function setPrev(string $prev): void
    {
        $this->prev = $prev;
    }
}