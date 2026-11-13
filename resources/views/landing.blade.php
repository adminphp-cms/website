@php
    $github = 'https://github.com/adminphp-cms';
    $features = [
        ['Modules', 'Une classe PHP par type de contenu : son formulaire, ses colonnes, ses filtres et sa recherche.', 'M4 6h16M4 12h16M4 18h10'],
        ['Éditeur de blocs', 'Des pages construites avec vos propres blocs : texte, image, citation… réordonnés par glisser-déposer.', 'M4 5h7v6H4zM13 5h7v4h-7zM13 11h7v8h-7zM4 13h7v6H4z'],
        ['Publication', 'Brouillons séparés de la version en ligne, programmation, aperçu des modifications et révisions restaurables.', 'M5 12l4 4L19 6'],
        ['Médiathèque', 'Envoi d’images avec copies WebP responsives, et suivi de leur utilisation : une image utilisée ne peut pas être supprimée.', 'M4 5h16v14H4zM4 15l5-5 4 4 3-3 4 4'],
        ['Multilingue', 'Chaque champ texte peut être traduit, avec le repli sur la langue par défaut et les traductions manquantes signalées.', 'M4 5h8M8 3v2m3 0c-1 5-4 8-7 9m3-5c1 2 3 4 6 5M13 21l4-9 4 9m-7-3h6'],
        ['Arborescences', 'Ordre manuel et sous-éléments pour les menus et les pages, déplaçables d’un niveau à l’autre.', 'M6 4v16M6 8h8M6 16h8M14 8h4M14 16h4'],
        ['Réglages', 'Un formulaire pour les valeurs du site (nom, logo, liens…), lues partout dans votre code.', 'M12 15a3 3 0 100-6 3 3 0 000 6zM19.4 15a1.7 1.7 0 00.3 1.8l.1.1a2 2 0 11-2.8 2.8l-.1-.1a1.7 1.7 0 00-2.9 1.2V21a2 2 0 11-4 0v-.1a1.7 1.7 0 00-2.9-1.2l-.1.1a2 2 0 11-2.8-2.8l.1-.1A1.7 1.7 0 003 15H3a2 2 0 110-4h.1A1.7 1.7 0 004.6 9l-.1-.1a2 2 0 112.8-2.8l.1.1A1.7 1.7 0 0010 5V5a2 2 0 114 0v.1a1.7 1.7 0 002.9 1.2l.1-.1a2 2 0 112.8 2.8l-.1.1a1.7 1.7 0 00-.3 1.8'],
        ['Équipe', 'Rôles administrateur et éditeur, invitations par e-mail, et verrous d’édition quand deux personnes ouvrent le même contenu.', 'M16 19v-1a4 4 0 00-4-4H7a4 4 0 00-4 4v1M9.5 10a3 3 0 100-6 3 3 0 000 6zM21 19v-1a4 4 0 00-3-3.9M16 4.1a3 3 0 010 5.8'],
        ['Générateurs', 'adminphp:make:module et adminphp:make:block créent le modèle, la migration et la classe en quelques secondes.', 'M7 8l-4 4 4 4M17 8l4 4-4 4M14 4l-4 16'],
    ];
@endphp
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>AdminPHP — le CMS Laravel qui reste du Laravel</title>
        <meta name="description" content="AdminPHP est un CMS pour Laravel : vous décrivez vos contenus en PHP, vos éditeurs écrivent, prévisualisent et publient, votre site les affiche avec Eloquent et Blade.">

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white text-zinc-700 antialiased dark:bg-zinc-950 dark:text-zinc-300">
        <header class="sticky top-0 z-30 border-b border-zinc-200/70 bg-white/80 backdrop-blur dark:border-zinc-800/70 dark:bg-zinc-950/80">
            <div class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-6 px-4 sm:px-6">
                <a href="{{ route('home') }}" class="text-lg font-semibold tracking-tight text-zinc-950 dark:text-white">Admin<span class="text-brand">PHP</span></a>

                <nav class="flex items-center gap-6 text-sm">
                    <a href="#fonctionnalites" class="hidden hover:text-zinc-950 sm:block dark:hover:text-white">Fonctionnalités</a>
                    <a href="#comment" class="hidden hover:text-zinc-950 sm:block dark:hover:text-white">Comment ça marche</a>
                    <a href="{{ $github }}/core" class="inline-flex items-center gap-2 rounded-full border border-zinc-200 px-3.5 py-1.5 font-medium text-zinc-900 hover:border-zinc-400 dark:border-zinc-700 dark:text-white dark:hover:border-zinc-500">
                        <x-github-icon class="size-4" />
                        GitHub
                    </a>
                </nav>
            </div>
        </header>

        <main>
            {{-- Hero --}}
            <section class="relative overflow-hidden">
                <div class="pointer-events-none absolute inset-x-0 -top-40 -z-10 flex justify-center" aria-hidden="true">
                    <div class="h-[36rem] w-[64rem] rounded-full bg-gradient-to-tr from-brand/25 via-orange-300/20 to-transparent blur-3xl dark:from-brand/20 dark:via-orange-500/10"></div>
                </div>

                <div class="mx-auto max-w-6xl px-4 pt-20 pb-16 text-center sm:px-6 sm:pt-28">
                    <p class="inline-flex items-center gap-2 rounded-full border border-brand/20 bg-brand/5 px-3 py-1 text-xs font-medium text-brand">
                        <span class="size-1.5 rounded-full bg-brand"></span>
                        Open source · Laravel 12 et 13
                    </p>

                    <h1 class="mx-auto mt-6 max-w-4xl text-4xl font-semibold tracking-tight text-balance text-zinc-950 sm:text-6xl dark:text-white">
                        Le CMS Laravel qui reste <span class="text-brand">du Laravel</span>.
                    </h1>

                    <p class="mx-auto mt-6 max-w-2xl text-lg text-pretty text-zinc-600 dark:text-zinc-400">
                        Vous décrivez vos contenus en PHP. Vos éditeurs écrivent, prévisualisent et publient dans une admin rapide.
                        Votre site les affiche avec Eloquent et Blade, comme n’importe quelle app Laravel.
                    </p>

                    <div class="mt-10 flex flex-col items-center justify-center gap-3 sm:flex-row">
                        <a href="{{ $github }}/starter" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-zinc-950 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-zinc-800 sm:w-auto dark:bg-white dark:text-zinc-950 dark:hover:bg-zinc-200">
                            Démarrer avec le starter
                            <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.64l-4.22-4.22a.75.75 0 111.06-1.06l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06l4.22-4.22H3.75A.75.75 0 013 10z" clip-rule="evenodd" /></svg>
                        </a>
                        <a href="{{ $github }}/core" class="inline-flex w-full items-center justify-center gap-2 rounded-full border border-zinc-300 px-6 py-3 text-sm font-semibold text-zinc-900 hover:border-zinc-500 sm:w-auto dark:border-zinc-700 dark:text-white dark:hover:border-zinc-500">
                            <x-github-icon class="size-4" />
                            Voir le code
                        </a>
                    </div>

                    <x-copy-command class="mx-auto mt-6 max-w-xl" command="composer require adminphp-cms/core" />
                </div>

                <div class="mx-auto max-w-6xl px-4 pb-24 sm:px-6">
                    <figure class="overflow-hidden rounded-xl border border-zinc-200 bg-zinc-100 shadow-2xl shadow-zinc-900/10 ring-1 ring-zinc-900/5 dark:border-zinc-800 dark:bg-zinc-900 dark:shadow-black/40">
                        <div class="flex items-center gap-1.5 border-b border-zinc-200 bg-zinc-50 px-4 py-3 dark:border-zinc-800 dark:bg-zinc-900" aria-hidden="true">
                            <span class="size-2.5 rounded-full bg-zinc-300 dark:bg-zinc-700"></span>
                            <span class="size-2.5 rounded-full bg-zinc-300 dark:bg-zinc-700"></span>
                            <span class="size-2.5 rounded-full bg-zinc-300 dark:bg-zinc-700"></span>
                            <span class="ml-3 truncate rounded-md bg-white px-3 py-0.5 text-xs text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">votre-site.ch/admin</span>
                        </div>
                        <img src="{{ asset('images/admin-editor.jpg') }}" width="1357" height="840" alt="L’éditeur d’AdminPHP : un article avec son titre, son chapeau, sa couverture, ses blocs de texte et de citation, et le panneau de publication." class="w-full" fetchpriority="high">
                    </figure>
                </div>
            </section>

            {{-- How it works --}}
            <section id="comment" class="scroll-mt-16 border-y border-zinc-200 bg-zinc-50 py-24 dark:border-zinc-800 dark:bg-zinc-900/40">
                <div class="mx-auto max-w-6xl px-4 sm:px-6">
                    <div class="max-w-2xl">
                        <p class="text-sm font-semibold text-brand">Comment ça marche</p>
                        <h2 class="mt-2 text-3xl font-semibold tracking-tight text-zinc-950 sm:text-4xl dark:text-white">Trois fichiers, et votre contenu est éditable.</h2>
                        <p class="mt-4 text-lg text-zinc-600 dark:text-zinc-400">Pas de configuration en base, pas de constructeur visuel à apprendre : tout vit dans votre code, versionné avec le reste.</p>
                    </div>

                    <div class="mt-14 grid gap-8 lg:grid-cols-3">
                        <x-landing-step number="1" title="Décrivez" text="Un module dit quels champs vos éditeurs remplissent.">
<span class="text-violet-400">class</span> <span class="text-amber-200">ProjectModule</span> <span class="text-violet-400">extends</span> Module
{
    <span class="text-violet-400">public function</span> <span class="text-sky-300">form</span>(): <span class="text-violet-400">array</span>
    {
        <span class="text-violet-400">return</span> [
            Text::<span class="text-sky-300">make</span>(<span class="text-emerald-300">'title'</span>)
                -><span class="text-sky-300">required</span>(),
            Image::<span class="text-sky-300">make</span>(<span class="text-emerald-300">'cover'</span>),
            Blocks::<span class="text-sky-300">make</span>(<span class="text-emerald-300">'content'</span>),
        ];
    }
}</x-landing-step>

                        <x-landing-step number="2" title="Éditez" text="L’admin est prête : formulaire, liste, aperçu, publication.">
<span class="text-zinc-500">$</span> php artisan adminphp:make:module \
    Project --publishable --blocks

<span class="text-emerald-300">  ✓ Modèle, migration et module créés</span>

<span class="text-zinc-500">$</span> php artisan migrate

<span class="text-zinc-500"># → votre-site.ch/admin/project</span></x-landing-step>

                        <x-landing-step number="3" title="Affichez" text="Des modèles Eloquent et des vues Blade, rien de plus.">
<span class="text-zinc-500">&#123;&#123;-- projects/show.blade.php --&#125;&#125;</span>
&lt;<span class="text-sky-300">h1</span>&gt;@{{ $project->title }}&lt;/<span class="text-sky-300">h1</span>&gt;

&lt;<span class="text-sky-300">x-adminphp::image</span>
    <span class="text-amber-200">:media</span>=<span class="text-emerald-300">"$project->coverMedia"</span> /&gt;

<span class="text-violet-400">@@foreach</span> ($project->blocks <span class="text-violet-400">as</span> $block)
    <span class="text-violet-400">@@include</span>(<span class="text-emerald-300">"blocks.{$block->type}"</span>)
<span class="text-violet-400">@@endforeach</span></x-landing-step>
                    </div>
                </div>
            </section>

            {{-- Features --}}
            <section id="fonctionnalites" class="scroll-mt-16 py-24">
                <div class="mx-auto max-w-6xl px-4 sm:px-6">
                    <div class="max-w-2xl">
                        <p class="text-sm font-semibold text-brand">Fonctionnalités</p>
                        <h2 class="mt-2 text-3xl font-semibold tracking-tight text-zinc-950 sm:text-4xl dark:text-white">Tout ce qu’il faut à un site éditorial.</h2>
                        <p class="mt-4 text-lg text-zinc-600 dark:text-zinc-400">Et rien qui vous enferme : vos contenus restent dans vos tables, avec vos modèles.</p>
                    </div>

                    <div class="mt-14 grid gap-px overflow-hidden rounded-2xl border border-zinc-200 bg-zinc-200 sm:grid-cols-2 lg:grid-cols-3 dark:border-zinc-800 dark:bg-zinc-800">
                        @foreach ($features as [$title, $text, $icon])
                            <div class="bg-white p-6 dark:bg-zinc-950">
                                <span class="grid size-10 place-items-center rounded-lg bg-brand/10 text-brand">
                                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $icon }}" /></svg>
                                </span>
                                <h3 class="mt-4 font-semibold text-zinc-950 dark:text-white">{{ $title }}</h3>
                                <p class="mt-2 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">{{ $text }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- For developers --}}
            <section class="bg-zinc-950 py-24 text-zinc-400">
                <div class="mx-auto grid max-w-6xl gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:items-center">
                    <div>
                        <p class="text-sm font-semibold text-brand">Pour les développeurs</p>
                        <h2 class="mt-2 text-3xl font-semibold tracking-tight text-white sm:text-4xl">Votre app, vos règles.</h2>
                        <p class="mt-4 text-lg">AdminPHP s’ajoute à une app Laravel existante comme n’importe quel package. L’admin est une SPA Vue livrée compilée : rien à builder de votre côté.</p>
                    </div>

                    <ul class="grid gap-4 sm:grid-cols-2">
                        @foreach ([
                            ['Eloquent et Blade', 'Vos modèles restent des modèles. Pas de couche à contourner pour afficher un contenu.'],
                            ['Testé partout', 'Plus de 240 tests, sur SQLite, MySQL et PostgreSQL, à chaque commit.'],
                            ['Mises à jour sereines', 'Les migrations gardent vos données quand le package évolue.'],
                            ['Libre', 'Licence MIT. Le code est sur GitHub, les contributions bienvenues.'],
                        ] as [$title, $text])
                            <li class="rounded-xl border border-zinc-800 bg-zinc-900/60 p-5">
                                <p class="font-semibold text-white">{{ $title }}</p>
                                <p class="mt-1.5 text-sm leading-relaxed">{{ $text }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>

            {{-- Call to action --}}
            <section class="py-24">
                <div class="mx-auto max-w-3xl px-4 text-center sm:px-6">
                    <h2 class="text-3xl font-semibold tracking-tight text-zinc-950 sm:text-4xl dark:text-white">Lancez votre prochain site en dix minutes.</h2>
                    <p class="mt-4 text-lg text-zinc-600 dark:text-zinc-400">Le starter contient des articles, des pages, un menu, des blocs et une démo complète.</p>
                    <x-copy-command class="mx-auto mt-8 max-w-2xl" command="git clone https://github.com/adminphp-cms/starter.git mon-site" />
                    <a href="{{ $github }}/starter" class="mt-8 inline-flex items-center gap-2 text-sm font-semibold text-brand hover:underline">
                        Lire le guide de démarrage
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
            </section>
        </main>

        <footer class="border-t border-zinc-200 dark:border-zinc-800">
            <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 px-4 py-8 text-sm sm:flex-row sm:px-6">
                <p>Admin<span class="text-brand">PHP</span> · Licence MIT</p>
                <nav class="flex gap-6">
                    <a href="{{ $github }}/core" class="hover:text-zinc-950 dark:hover:text-white">Core</a>
                    <a href="{{ $github }}/starter" class="hover:text-zinc-950 dark:hover:text-white">Starter</a>
                    <a href="{{ $github }}" class="hover:text-zinc-950 dark:hover:text-white">GitHub</a>
                </nav>
            </div>
        </footer>
    </body>
</html>
