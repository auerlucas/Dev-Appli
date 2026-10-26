<?php

declare(strict_types=1);

namespace Html;

class WebPage
{
    private string $head = "";
    private string $title = "";
    private string $body = "";

    /**
     * Constructeur de la page web
     * @param string $title
     */
    public function __construct(string $title = "")
    {
        $this->title = $title;
    }

    /**
     * Retourne le contenu de la balise head
     * @return string
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /**
     * Retourne le titre de la page
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Définit le titre de la page
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Retourne le contenu du body
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Ajoute du contenu brut dans le head
     * @param string $content
     * @return void
     */
    public function appendToHead(string $content): void
    {
        $this->head .= $content;
    }

    /**
     * Ajoute du code CSS
     * @param string $css
     * @return void
     */
    public function appendCss(string $css): void
    {
        $this->head .= "<style>{$css}</style>\n";
    }

    /**
     * Ajoute un lien vers une feuille de style
     * @param string $url
     * @return void
     */
    public function appendCssUrl(string $url): void
    {
        $this->head .= "<link rel=\"stylesheet\" href=\"{$url}\">\n";
    }

    /**
     * Ajoute du code JavaScript
     * @param $js
     * @return void
     */
    public function appendJs(string $js): void
    {
        $this->head .= "<script>{$js}</script>\n";
    }

    /**
     * Ajoute un lien vers un fichier JavaScrip
     * @param string $url
     * @return void
     */
    public function appendJsUrl(string $url): void
    {
        $this->head .= "<script src=\"{$url}\"></script>\n";
    }

    /**
     * Ajoute du contenu au corps de la page
     * @param string $content
     * @return void
     */
    public function appendContent(string $content): void
    {
        $this->body .= $content;
    }

    /**
     * Génère le code HTML
     * @return string
     */
    public function toHTML(): string
    {
        return <<<HTML
<!doctype html>
<html lang="fr">
    <head>
        <meta name="viewport" charset="utf-8">
        {$this->head}
        <title>{$this->title}</title>
    </head>
    <body>
            {$this->body}
            
            <p>Dernière modification : {$this->getLastModification()}</p>
    </body>
</html>
HTML;
    }

    /**
     * Retourne la dernière modification
     * @return string
     */
    public function getLastModification(): string
    {
        return date("F d Y H:i:s.", getlastmod());
    }

    /**
     * Protége les caractères spéciaux pouvant dégrader la page Web
     * @param string $string
     * @return string
     */
    public function escapeString(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}
