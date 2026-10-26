<?php

declare(strict_types=1);

namespace Html;

class AppWebPage extends WebPage
{
    /**
     * Constructeur de la classe AppWebPage
     * @param string $title
     */
    public function __construct(string $title = "")
    {
        parent::__construct($title);
        $this->appendCssUrl("css/style.css");
    }

    /**
     * Redéfinition de la méthode toHTML
     * @return string
     */
    public function toHTML(): string
    {
        $title = $this->escapeString($this->getTitle());
        $head = $this->getHead();
        $body = $this->getBody();
        $lastModification = $this->getLastModification();

        return <<<HTML
            <!doctype html>
            <html lang="fr">
                <head>
                    <meta name="viewport" charset="utf-8">
                    {$head}
                    <title>{$title}</title>
                </head>
                <body>
                    <header class="header">
                        <h1>{$title}</h1>
                    </header>
            
                    {$body}
            
                    <footer class="footer">
                        <p>Dernière modification : {$lastModification}</p>
                    </footer>
                </body>
            </html>
            HTML;
    }
}
