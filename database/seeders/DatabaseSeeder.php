<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Friend;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->importMedia();

        // ---- Admin user ----------------------------------------------------
        User::updateOrCreate(
            ['email' => 'admin@akemingolf.test'],
            ['name' => '光本 朱見', 'password' => Hash::make('AkeminGolf!2026')]
        );

        // ---- Editable page sections ---------------------------------------
        $sections = [
            [
                'key' => 'hero', 'sort' => 1, 'eyebrow' => 'Golf · Beauty · World Friends',
                'image' => 'media/portrait.jpg',
                'title' => [
                    'ja' => 'クラブを握れば、<br>世界が友になる。',
                    'en' => 'Hold a club, <br>and the world becomes a friend.',
                    'zh' => '握起球杆，<br>世界便成为朋友。',
                ],
                'lead' => [
                    'ja' => 'ゴルフを通して世界中に友達を増やし、つなぐ。美容と健康をみがき、毎日を挑戦に変えて——目指すは、Global Grandmother。',
                    'en' => 'Through golf I make friends across the world and connect them. Polishing beauty and health, turning each day into a challenge — aiming to become a Global Grandmother.',
                    'zh' => '透过高尔夫，在世界各地结交朋友并连接彼此。磨炼美丽与健康，把每一天化作挑战——目标是成为 Global Grandmother。',
                ],
            ],
            [
                'key' => 'about', 'sort' => 2, 'eyebrow' => 'About',
                'image' => 'media/portrait.jpg',
                'title' => [
                    'ja' => '美容鍼の世界から、<br>グリーンの上へ。',
                    'en' => 'From beauty acupuncture, <br>onto the green.',
                    'zh' => '从美容针灸的世界，<br>走上果岭。',
                ],
                'lead' => [
                    'ja' => 'ハリジェンヌ主宰・光本朱見。世界で仕事しながら、ゴルフで友をつないでいます。',
                    'en' => 'Akemi Mitsumoto, founder of Harisienne. Working around the world, connecting friends through golf.',
                    'zh' => 'Harisienne 创始人・光本朱见。在世界各地工作的同时，用高尔夫连接朋友。',
                ],
                'body' => [
                    'ja' => "はじめまして、光本朱見（あけみん）です。\n美容鍼サロン「ハリジェンヌ」を主宰し、世界35カ国で美と健康を学んできました。\n\nゴルフは、私にとって人生そのもの。グリーンに立てば、言葉も年齢も国境も関係なく、ひとつの笑顔でつながれます。\n\n美容・集中力・健康・体力・足腰——ゴルフはそのすべてを磨いてくれる。だから私は、ゴルフを通して世界中に友達を増やし、エネルギーを高めながら、Global Grandmother を目指しています。",
                    'en' => "Hello, I'm Akemi Mitsumoto — \"Akemin.\" I run the beauty-acupuncture salon Harisienne, and I've studied beauty and health across 35 countries.\n\nGolf, to me, is life itself. On the green, language, age and borders melt away — a single smile connects us.\n\nBeauty, focus, health, stamina, strong legs — golf polishes them all. So through golf I keep growing a circle of friends across the world, raising my energy, aiming to become a Global Grandmother.",
                    'zh' => "您好，我是光本朱见——大家叫我「Akemin」。我经营美容针灸沙龙 Harisienne，并在世界 35 个国家学习美容与健康。\n\n高尔夫对我而言就是人生本身。站上果岭，语言、年龄与国界都不再重要，一个微笑就能让人相连。\n\n美容、专注力、健康、体力、腿脚——高尔夫磨炼着这一切。所以我透过高尔夫，在世界各地不断结交朋友，提升能量，立志成为 Global Grandmother。",
                ],
            ],
            [
                'key' => 'beauty', 'sort' => 3, 'eyebrow' => 'Golf & Beauty',
                'image' => 'media/tropical.jpg',
                'title' => [
                    'ja' => 'ゴルフは、最高の美容法。',
                    'en' => 'Golf is the finest beauty ritual.',
                    'zh' => '高尔夫，是最好的美容法。',
                ],
                'lead' => [
                    'ja' => '一打ごとに、こころと体が整っていく。あけみんが信じる、五つのめぐみ。',
                    'en' => 'With every shot, body and mind come into balance — the five gifts Akemin believes in.',
                    'zh' => '每一杆，身心都更趋平衡——这是 Akemin 所相信的五种馈赠。',
                ],
                'body' => [
                    'ja' => "美容鍼を通して、私はずっと「内側からの美しさ」を追い求めてきました。\nゴルフは、その答えのひとつ。\n\n太陽を浴び、緑の中を歩き、深く呼吸する。仲間と笑い合いながら一万歩を歩けば、肌も心も、自然と輝きを取り戻していきます。\n美は、特別な日のものではなく、毎日の積み重ね。グリーンの上の時間は、私にとって最高のスキンケアです。",
                    'en' => "Through beauty acupuncture, I have always pursued beauty that comes from within. Golf is one of the answers.\n\nBathing in the sun, walking through green, breathing deeply. Laughing with friends across ten thousand steps — skin and heart naturally regain their glow.\nBeauty is not for special days; it is built daily. Time on the green is, to me, the finest skincare.",
                    'zh' => "透过美容针灸，我一直在追寻「由内而外的美」。高尔夫，正是答案之一。\n\n沐浴阳光，行走在绿意之间，深深呼吸。与伙伴欢笑着走过一万步，肌肤与心灵都会自然焕发光彩。\n美，不属于特别的日子，而是每天的累积。果岭上的时光，对我而言就是最好的护肤。",
                ],
            ],
            [
                'key' => 'future', 'sort' => 4, 'eyebrow' => 'The Road Ahead',
                'image' => 'media/future.jpg',
                'title' => [
                    'ja' => 'これからの、ゴルフ。',
                    'en' => 'The road ahead.',
                    'zh' => '未来的高尔夫。',
                ],
                'lead' => [
                    'ja' => '一打ごとに、未来をひらいていく。あけみんが描く、これからの景色。',
                    'en' => 'Opening the future with every shot — the landscape Akemin imagines.',
                    'zh' => '每一杆都在开启未来——Akemin 所描绘的前方风景。',
                ],
                'body' => [
                    'ja' => "目標は、Global Grandmother。\n世界中のグリーンに立ち、年齢を重ねるほどに自由に、しなやかに。\n\nいつか、出会った友と同じコースを歩き、それぞれの国の言葉で笑い合いたい。\nゴルフは、その夢への一歩。これからも毎日挑戦し、エネルギーを高めていきます。",
                    'en' => "My goal is to be a Global Grandmother — standing on greens around the world, growing freer and more graceful with every year.\n\nOne day I want to walk the same course with the friends I've met, laughing together each in our own language.\nGolf is a step toward that dream. I'll keep challenging myself every day, raising my energy.",
                    'zh' => "我的目标，是成为 Global Grandmother——站在世界各地的果岭上，随着年岁增长而愈发自由、优雅。\n\n有一天，我想与相遇的朋友走在同一条球道上，用各自的语言一起欢笑。\n高尔夫，是迈向这个梦想的一步。今后我也会每天挑战，让能量不断提升。",
                ],
            ],
            [
                'key' => 'global', 'sort' => 5, 'eyebrow' => 'Global Golf',
                'image' => 'media/airport.jpg',
                'title' => [
                    'ja' => 'グリーンは、<br>世界へつづいている。',
                    'en' => 'The green <br>stretches into the world.',
                    'zh' => '果岭，<br>通向整个世界。',
                ],
                'lead' => [
                    'ja' => 'クラブひとつを携えて、国から国へ。ゴルフは、世界中の友と出会うためのパスポート。',
                    'en' => 'With a single set of clubs, from country to country — golf is a passport to friends across the world.',
                    'zh' => '带着一套球杆，从一个国家到另一个国家——高尔夫，是结识世界朋友的护照。',
                ],
                'body' => [
                    'ja' => "東京、ロサンゼルス、シンガポール、ドバイ、パリ、ムンバイ。\nクラブを抱えて飛行機に乗るたび、新しい友との出会いが待っています。\n\n同じグリーンに立てば、私たちはもう仲間。ゴルフは、世界をひとつにつなぐ共通言語です。",
                    'en' => "Tokyo, Los Angeles, Singapore, Dubai, Paris, Mumbai.\nEvery time I board a plane with my clubs, a new friendship is waiting.\n\nStand on the same green and we are already companions. Golf is a shared language that connects the world as one.",
                    'zh' => "东京、洛杉矶、新加坡、迪拜、巴黎、孟买。\n每当我带着球杆登上飞机，都有新的朋友在等待。\n\n只要站上同一片果岭，我们就已是伙伴。高尔夫，是把世界连为一体的共通语言。",
                ],
            ],
        ];
        foreach ($sections as $data) {
            Section::updateOrCreate(['key' => $data['key']], $data);
        }

        // ---- Activities ----------------------------------------------------
        $activities = [
            [
                'happened_on' => '2026-05-18', 'location' => 'Los Angeles, California', 'sort' => 1,
                'cover_image' => 'media/la-round.jpg',
                'title' => ['ja' => 'ロサンゼルスで、世界の仲間とラウンド', 'en' => 'A round with friends from around the world in LA', 'zh' => '在洛杉矶，与世界各地的伙伴同场'],
                'body' => [
                    'ja' => "ジャカランダの花が咲くロサンゼルスのコースで、世界各地の仲間とラウンドしました。\n国も言葉もちがうのに、ナイスショットには同じ笑顔。これがあけみんゴルフの原点です。",
                    'en' => "On a Los Angeles course lined with blooming jacaranda, I played a round with friends from across the world.\nDifferent countries, different languages — yet the same smile for a good shot. This is where Akemin Golf begins.",
                    'zh' => "在蓝花楹盛开的洛杉矶球场，我与来自世界各地的伙伴一起打了一轮。\n国家不同、语言不同，但好球都换来同样的笑容。这正是 Akemin Golf 的原点。",
                ],
            ],
            [
                'happened_on' => '2026-04-09', 'location' => 'Tropical Resort Course', 'sort' => 2,
                'cover_image' => 'media/tropical.jpg',
                'title' => ['ja' => '南国のグリーンで、しなやかに', 'en' => 'Supple and strong on a tropical green', 'zh' => '在南国果岭，柔韧而有力'],
                'body' => [
                    'ja' => "ヤシの木が並ぶ南国のコースへ。日差し対策をしっかりして、足腰を使ってしっかり歩く。\n美容も健康も、楽しみながら。汗をかいた分だけ、心も軽くなりました。",
                    'en' => "To a tropical course lined with palm trees. Fully shielded from the sun, walking strong on my legs.\nBeauty and health, while having fun. The more I sweat, the lighter my heart became.",
                    'zh' => "来到棕榈成排的南国球场。做好防晒，用腿脚稳稳地行走。\n美容与健康，都在快乐中进行。流多少汗，心情就轻盈多少。",
                ],
            ],
            [
                'happened_on' => '2026-03-22', 'location' => 'Narita → The World', 'sort' => 3,
                'cover_image' => 'media/airport.jpg',
                'title' => ['ja' => 'クラブを抱えて、次の国へ', 'en' => 'Clubs in hand, off to the next country', 'zh' => '抱起球杆，飞向下一个国家'],
                'body' => [
                    'ja' => "成田の出発ロビー。スーツケースの隣には、いつもゴルフバッグ。\nこの一本があれば、どこへ行っても友達ができる。さあ、次のグリーンへ。",
                    'en' => "The departure lobby at Narita. Beside my suitcase, always a golf bag.\nWith these clubs, I can make friends anywhere I go. Now, on to the next green.",
                    'zh' => "成田机场的出发大厅。行李箱旁，总有一只高尔夫球包。\n只要带着这套球杆，无论去到哪里都能交到朋友。出发，前往下一片果岭。",
                ],
            ],
            [
                'happened_on' => '2026-02-14', 'location' => 'Akemin Golf Day', 'sort' => 4,
                'cover_image' => 'media/round2.jpg',
                'title' => ['ja' => '今日も一打、一歩、前へ', 'en' => 'One shot, one step forward — again today', 'zh' => '今天也是一杆、一步，向前'],
                'body' => [
                    'ja' => "毎日が小さな挑戦。昨日より少しだけ遠くへ、まっすぐに。\nゴルフが教えてくれるのは、人生も同じだということ。",
                    'en' => "Every day is a small challenge. A little farther, a little straighter than yesterday.\nWhat golf teaches me is that life is just the same.",
                    'zh' => "每天都是小小的挑战。比昨天再远一点、再直一点。\n高尔夫教会我的是——人生，也是如此。",
                ],
            ],
        ];
        foreach ($activities as $a) {
            Activity::create($a);
        }

        // ---- Friends -------------------------------------------------------
        $friends = [
            ['name' => 'Akemi (UAE)', 'country' => 'Dubai, UAE', 'country_code' => 'ae', 'flag' => '🇦🇪', 'instagram' => 'akemi_harisienne_uae', 'sort' => 1, 'photo' => 'media/airport.jpg',
             'message' => ['ja' => '砂漠の国から、世界へ。', 'en' => 'From the desert, to the world.', 'zh' => '从沙漠之国，走向世界。']],
            ['name' => 'Harisienne India', 'country' => 'Mumbai, India', 'country_code' => 'in', 'flag' => '🇮🇳', 'instagram' => 'akemi_harisienne_ind', 'sort' => 2,
             'message' => ['ja' => '色とりどりの笑顔で。', 'en' => 'With colourful smiles.', 'zh' => '以缤纷的笑容相聚。']],
            ['name' => 'Harisienne Singapore', 'country' => 'Singapore', 'country_code' => 'sg', 'flag' => '🇸🇬', 'instagram' => 'akemi_harisienne_sg', 'sort' => 3, 'photo' => 'media/tropical.jpg',
             'message' => ['ja' => '常夏のグリーンで。', 'en' => 'On an ever-summer green.', 'zh' => '在四季常夏的果岭。']],
            ['name' => 'LA Golf Sisters', 'country' => 'Los Angeles, USA', 'country_code' => 'us', 'flag' => '🇺🇸', 'instagram' => 'aki_golf30', 'sort' => 4, 'photo' => 'media/la-round.jpg',
             'message' => ['ja' => 'ナイスショットで乾杯！', 'en' => 'Cheers to a nice shot!', 'zh' => '为漂亮的一杆干杯！']],
            ['name' => 'Paris Amies', 'country' => 'Paris, France', 'country_code' => 'fr', 'flag' => '🇫🇷', 'sort' => 5,
             'message' => ['ja' => 'エレガンスをグリーンにも。', 'en' => 'Elegance, even on the green.', 'zh' => '把优雅也带上果岭。']],
            ['name' => 'Tokyo Members', 'country' => 'Tokyo, Japan', 'country_code' => 'jp', 'flag' => '🇯🇵', 'sort' => 6,
             'message' => ['ja' => 'すべての始まりの街で。', 'en' => 'Where it all began.', 'zh' => '在一切开始的城市。']],
        ];
        foreach ($friends as $f) {
            Friend::create($f);
        }

        // ---- Essays (Golf & Life) -----------------------------------------
        $posts = [
            [
                'slug' => 'golf-and-life', 'category' => 'life', 'published_at' => '2026-05-01', 'sort' => 1,
                'cover_image' => 'media/tropical.jpg',
                'title' => ['ja' => '一打に、人生がある', 'en' => 'In a single shot, a whole life', 'zh' => '一杆之中，自有人生'],
                'excerpt' => [
                    'ja' => 'うまくいく日も、いかない日も。それでも前を向いて、次の一打を打つ。',
                    'en' => 'Good days and bad days alike — still we face forward and play the next shot.',
                    'zh' => '顺利的日子，也有不顺的日子。即便如此，仍向前迈出，挥出下一杆。',
                ],
                'body' => [
                    'ja' => "ゴルフは、人生によく似ています。\nうまくいく日もあれば、思うようにいかない日もある。\n\nでも、ミスショットの後こそ大切。落ち込むより、深呼吸して、次の一打に集中する。\nその切り替えが、グリーンの外でも私を支えてくれます。\n\n毎日挑戦し、エネルギーを高める。今日の一打が、明日の自分をつくっていく。",
                    'en' => "Golf is very much like life.\nThere are days it goes well, and days it simply doesn't.\n\nBut it's after a missed shot that matters most. Rather than sink, I breathe deep and focus on the next one.\nThat reset supports me far beyond the green.\n\nChallenge every day, raise your energy. Today's shot shapes tomorrow's self.",
                    'zh' => "高尔夫，与人生十分相似。\n有顺利的日子，也有事与愿违的日子。\n\n但最关键的，往往是失误之后。与其沮丧，不如深呼吸，专注于下一杆。\n这份转念，也在果岭之外支撑着我。\n\n每天挑战，提升能量。今天的一杆，塑造明天的自己。",
                ],
            ],
            [
                'slug' => 'global-grandmother', 'category' => 'life', 'published_at' => '2026-04-12', 'sort' => 2,
                'cover_image' => 'media/portrait.jpg',
                'title' => ['ja' => 'Global Grandmother への道', 'en' => 'The road to Global Grandmother', 'zh' => '通往 Global Grandmother 之路'],
                'excerpt' => [
                    'ja' => '歳を重ねることは、世界が広がること。しなやかに、自由に。',
                    'en' => 'To grow older is to grow wider — supple, and free.',
                    'zh' => '年岁渐长，是世界的拓宽——柔韧，而自由。',
                ],
                'body' => [
                    'ja' => "私の夢は、世界中に孫のような友達がいる「Global Grandmother」になること。\n\nそのために、美容も健康も、足腰も、毎日少しずつ。\nいくつになっても自分の足でグリーンを歩き、世界中の友に会いにいきたい。\n\n年齢は、あきらめる理由にはならない。むしろ、これからが本番です。",
                    'en' => "My dream is to become a \"Global Grandmother\" — with friends like grandchildren all over the world.\n\nFor that, I tend to beauty, health, and strong legs, a little each day.\nNo matter my age, I want to walk the green on my own feet and visit friends across the world.\n\nAge is no reason to give up. If anything, the real game starts now.",
                    'zh' => "我的梦想，是成为在世界各地都有「孙辈般朋友」的 Global Grandmother。\n\n为此，美容、健康与腿脚，我都每天一点一点地照料。\n无论到了什么年纪，我都想用自己的双脚走在果岭上，去见世界各地的朋友。\n\n年龄，不是放弃的理由。相反，真正的精彩，现在才开始。",
                ],
            ],
        ];
        foreach ($posts as $p) {
            Post::create($p);
        }

        // ---- Gallery -------------------------------------------------------
        $gallery = [
            ['media/la-round.jpg', 'Los Angeles', ['ja' => 'LAで世界の仲間と']],
            ['media/tropical.jpg', 'Tropical', ['ja' => '南国のグリーン']],
            ['media/airport.jpg', 'Travel', ['ja' => '次の国へ']],
            ['media/round2.jpg', 'Round', ['ja' => '今日も一打']],
            ['media/portrait.jpg', 'Portrait', ['ja' => 'あけみん']],
        ];
        foreach ($gallery as $i => [$path, $album, $caption]) {
            Photo::create(['path' => $path, 'album' => $album, 'caption' => $caption, 'sort' => $i]);
        }
    }

    /**
     * Copy the real source media into the public storage disk.
     */
    private function importMedia(): void
    {
        $src = base_path('_source-media');
        $dest = storage_path('app/public/media');

        if (! is_dir($dest)) {
            mkdir($dest, 0775, true);
        }

        $map = [
            'akemi_mitsumoto.jpg' => 'portrait.jpg',
            'S__55009323_0.jpg'   => 'la-round.jpg',
            'S__55009325_0.jpg'   => 'tropical.jpg',
            'S__55009326_0.jpg'   => 'beauty.jpg',
            'S__55009327_0.jpg'   => 'airport.jpg',
            'S__55009328_0.jpg'   => 'round2.jpg',
            'golf-akemi.mp4'      => 'golf.mp4',
        ];

        foreach ($map as $from => $to) {
            $fromPath = $src.DIRECTORY_SEPARATOR.$from;
            if (is_file($fromPath)) {
                copy($fromPath, $dest.DIRECTORY_SEPARATOR.$to);
            }
        }

        // friendly aliases used by some views as fallbacks
        foreach (['about.jpg' => 'portrait.jpg', 'future.jpg' => 'round2.jpg', 'friends.jpg' => 'la-round.jpg'] as $alias => $real) {
            $realPath = $dest.DIRECTORY_SEPARATOR.$real;
            if (is_file($realPath) && ! is_file($dest.DIRECTORY_SEPARATOR.$alias)) {
                copy($realPath, $dest.DIRECTORY_SEPARATOR.$alias);
            }
        }
    }
}
