<?php

/**
 * helpers/articles.php
 * - Holds categories + articles data
 * - Includes safe renderer for article content (mini-markdown)
 */

/* =========================
   1) CATEGORIES (real slugs)
   ========================= */
$ARTICLE_CATEGORIES = [
  [
    'slug' => 'what-is-breastfeeding',
    'name' => 'What is Breastfeeding?',
    'hero' => '/MILKYWAY/public/images/articles/intro-hero.jpg',
    'ribbon_class' => 'ribbon-pink',
  ],
  [
    'slug' => 'problems',
    'name' => 'Problems Encounter During Breastfeeding',
    'hero' => '/MILKYWAY/public/images/articles/problems-hero.jpg',
    'ribbon_class' => 'ribbon-red',
  ],
  [
    'slug' => 'tips',
    'name' => 'BREASTFEEDING TIPS',
    'hero' => '/MILKYWAY/public/images/articles/tips-hero.jpg',
    'ribbon_class' => 'ribbon-purple',
  ],
];

/* =========================
   2) ARTICLES
   - cat MUST match category slug
   - add: thumb, revised, source_url (optional)
   ========================= */
$ARTICLES = [
  [
    'id' => 1,
    'cat' => 'what-is-breastfeeding',
    'title' => 'Breastfeeding',
    'author' => 'WHO',
    'revised' => '2026',
    'thumb' => '/MILKYWAY/public/images/articles/thumbs/breastfeeding.jpg', // optional
    'overview' => 'Breastfeeding is one of the most effective ways to ensure child health and survival, yet exclusive breastfeeding rates remain below recommendations.',
    'source_url' => '', // optional
    'content' => <<<'MD'
Overview: 
Breastfeeding is one of the most effective ways to ensure child health and survival. However, contrary to WHO recommendations, fewer than half of infants under 6 months old are exclusively breastfed.

Breastmilk is the ideal food for infants. It is safe, clean and contains antibodies which help protect against many common childhood illnesses. Breastmilk provides all the energy and nutrients that the infant needs for the first months of life, and it continues to provide up to half or more of a child’s nutritional needs during the second half of the first year, and up to one third during the second year of life. 

Breastfed children perform better on intelligence tests, are less likely to be overweight or obese and less prone to diabetes later in life. Women who breastfeed also have a reduced risk of breast and ovarian cancers. 

Inappropriate marketing of breast-milk substitutes continues to undermine efforts to improve breastfeeding rates and duration worldwide.

**Recommendations:**
WHO and UNICEF recommend that children initiate breastfeeding within the first hour of birth and be exclusively breastfed for the first 6 months of life – meaning no other foods or liquids are provided, including water. 

Infants should be breastfed on demand – that is as often as the child wants, day and night. No bottles, teats or pacifiers should be used. 

From the age of 6 months, children should begin eating safe and adequate complementary foods while continuing to breastfeed for up to two years of age or beyond.

**WHO response:**
WHO actively promotes breastfeeding as the best source of nourishment for infants and young children, and is working to increase the rate of exclusive breastfeeding for the first 6 months up to at least 50% by 2025. 

WHO and UNICEF created the Global Breastfeeding Collective to rally political, legal, financial, and public support for breastfeeding. The Collective brings together implementers and donors from governments, philanthropies, international organizations, and civil society. 

WHO’s Network for Global Monitoring and Support for Implementation of the International Code of Marketing of Breast-milk Substitutes, also known as NetCode, works to ensure that breast-milk substitutes are not marketed inappropriately.
MD
  ],

  [
    'id' => 2,
    'cat' => 'what-is-breastfeeding',
    'title' => 'Breastfeeding: How to start, benefits & common concerns',
    'author' => 'Cleveland Clinic (2021)',
    'thumb' => '/MILKYWAY/public/images/articles/thumbs/how-to-start.jpg', // optional
    'overview' => 'Explains what breastfeeding is, how it works, how to start, what to avoid, birth control options, challenges, and where to get help.',
    'source_url' => '',
    'content' => <<<'MD'
## What is breastfeeding?

Breastfeeding is the process of feeding your baby milk that your body has made. Your baby attaches their mouth onto your breast and, through a suckling motion, drinks milk. Your baby will likely start breastfeeding soon after birth, often within the first few hours.

At first, your body will make an early form of milk called colostrum. This is a protein-rich, thick liquid. It’s full of antibodies that help guard your newborn against infections. Your colostrum will change into mature milk after about three to five days of breastfeeding. During this time, your baby will lose a bit of weight. This is normal. They’ll regain it once your milk “comes in.”

Breastfeeding has many benefits both for you and your baby. These include lowering your risk for postpartum depression and building your baby’s immune system.

If possible, exclusively breastfeed your baby for their first six months of life. Continue breastfeeding as you introduce solid foods. Because breastmilk has so many benefits, you can keep providing it until your baby’s second birthday or longer.

Keep in mind that there are many ways to feed your baby. You might nurse directly. You might pump milk to feed your baby with a bottle. You may breastfeed and supplement with formula. You may use only formula or donor breast milk. Your needs and your baby’s needs might change over time. What matters most is that your baby has the nutrients they need to grow and develop. Your healthcare provider can guide you on what’s best in your situation.

**How does breastfeeding work?**

Milk makes its way from your body to your baby through a series of steps:

• Your baby latches on to your breast.
• Your baby’s suckling stimulates nerves that tell your body to release certain hormones (prolactin and oxytocin).
• Prolactin tells your alveoli (tiny sacs in your breasts) to make milk.
• Oxytocin triggers the release of milk (let-down) into your milk ducts and out through your nipple.

You might hear your provider say that lactation works on a supply and demand basis. This means your body takes cues from your baby’s “demands” to know how much milk to produce. If your baby empties your breast, your body will replenish the supply. If your baby removes less milk because they’re starting solids, your body will adjust and make less.

This is why pumping while you’re away from your baby can help you keep up your supply. When milk is removed, your body knows to make more. This is also why you shouldn’t pump to “empty your breasts” to get rid of engorgement if you have an issue with overproduction. Draining your breasts only tells your body to make more milk.

**How do I start breastfeeding?**

A healthcare provider will help you get started soon after delivery. If you and your baby are healthy, you’ll hold your baby against your skin for at least two hours. This is called skin-to-skin contact. This close contact encourages your baby to bond and breastfeed.

Your baby will eventually start moving toward your breast. This is an instinct, and it’s a special one for you to witness! Your provider can help make sure your baby latches on and begins taking in milk.

For every breastfeeding session after, you’ll:

1. Find a breastfeeding position that’s comfortable for you and your baby, bringing your baby close to you.

2. Guide your baby’s mouth to your nipple. The nipple should be pointing toward their nose. Your baby’s chin should be resting against the bottom part of your breast.

3. Help your baby latch on. Their mouth should be wide open and cover most of the bottom part of your areola. Some of your areola should be visible above their upper lip.

4. Let your baby suckle to remove milk from your breast. They’ll settle into a rhythm of suckling and short pauses. You should be able to hear your baby swallow as they take in milk. Let your baby feed from this breast until they stop suckling and swallowing or until they let go.

5. Burp your baby for several minutes.

6. Offer your other breast to your baby. If your baby’s had enough to fill their tummy, they may turn away, and that’s OK.

The next time you feed your baby, start with the breast that wasn’t emptied as much. It’ll likely feel fuller because it contains more milk.

Your baby might be hungry if they:

• Act alert
• Turn their head to look at your breast or move toward it
• Suck on their hands, smack their lips or stick out their tongue
• Move their hands toward their mouth in fists or suck on their fingers (but past the newborn stage, this might just be a sign of curiosity and not hunger)

Your baby is likely full if they:

• Break their latch
• Seem relaxed
• Open up their fists
• Turn away from your breast (but past the newborn stage, this might just mean they’re distracted)

**What foods, drinks or substances should I avoid while breastfeeding?**

Just like during pregnancy, you should pay attention to what you eat and drink when you’re breastfeeding. There aren’t as many restrictions when you’re breastfeeding compared to pregnancy. But there are some things to limit or avoid:

• Limit caffeine. It’s OK to still have some caffeine, but no more than 300 milligrams (mg) per day. That’s about two 12-ounce mugs of coffee. Don’t forget to count tea (about 37 mg of caffeine per 12-ounce mug), sodas (23 to 83 mg per can) and chocolates.
• Limit alcohol. There aren’t any known risks to drinking up to one standard drink per day when you’re breastfeeding. But you should drink it at least two hours before nursing. This lets the alcohol clear from your system.
• Avoid fish with high mercury levels. Mercury from the fish you eat passes into your breastmilk. It can harm your baby’s brain and nervous system. Don’t eat any fish that’s high in mercury, including king mackerel, marlin, orange roughy, shark and swordfish.
• Avoid nicotine. Smoking or vaping reduces the nutritional value of your breastmilk and lowers your supply. Secondhand smoke raises your baby’s risk for allergies, upper respiratory infections and sudden infant death syndrome.
• Avoid marijuana. Experts don’t know how marijuana exposure might affect your baby. It may cause harm. So, it’s a good idea to avoid using any marijuana or being exposed to secondhand smoke.
• Avoid nonprescribed substances. Substances like opioids, benzodiazepines, stimulants, cocaine and phencyclidine (PCP or “angel dust”) can harm your baby. If you’re living with a substance use disorder, your provider can offer treatment to help.
• Avoid certain medicines. Most common medicines are safe to take while breastfeeding. But some may harm your baby or reduce your milk supply. It’s always a good idea to ask your provider or pharmacist before taking any medicine or supplements.

**Can I use birth control while I’m breastfeeding?**

Yes, but you should talk with your healthcare provider about the best type for you and when to start it. In general, it’s safe to use:

•  Barrier methods (like a condom or vaginal diaphragm)
•  IUDs (these can often be implanted right after you deliver your baby)
•  Progestin-only hormonal methods (like the “mini-pill”)

Hormonal birth control methods that contain estrogen (like certain pills, patches and vaginal rings) may lower your milk supply. So, your provider may suggest you avoid them or wait at least one month after giving birth (and take the lowest possible dose).

Remember that you can still get pregnant while breastfeeding — even if you haven’t gotten a period yet.

** Are there any reasons I shouldn’t breastfeed? **

Healthcare providers recommend breastfeeding in most situations. But you shouldn’t breastfeed if:

• Your baby is diagnosed with galactosemia (a condition that makes it hard for their body to process a sugar found in breastmilk)
• You have certain infections that could spread through your breastmilk, like HIV (with certain criteria like a detectable viral load), HTLV-1, HTLV-2, brucellosis or Ebola virus disease
• You have herpes sores on your breast
• You have hepatitis C along with cracked or bleeding nipples

Some of these situations are temporary. Your provider will tell you if and when it’s safe to nurse. They’ll also explain other options for feeding your baby, like formula and donor breast milk.

**What challenges might I face when breastfeeding?**

If you run into challenges while breastfeeding — or have trouble getting started — you’re not alone. It’s common to face issues like:

• Breast engorgement
• Oversupply of milk (hyperlactation)
• Low supply of milk
• Clogged milk ducts
• Breast inflammation (mastitis)
• Nipple blebs
• Sore, cracked or painful nipples
• Pain or bleeding from your baby’s teeth/biting
• Latching difficulties, which may be more likely if your baby has tongue-tie or cleft lip/cleft palate
• Challenges due to your nipple anatomy (flat or inverted nipples)
• Challenges with expressing milk by hand or with a breast pump
• Difficulty weaningThe most important thing to know is that help is available. Often, these issues are solvable. Healthcare providers can help you manage any challenges so you can continue breastfeeding for as long as you’d like.

**Who can help with breastfeeding?**

When you’re trying to learn how to breastfeed or solve a problem, you might wonder where to turn for help. You can always contact your primary care provider or obstetrician to get started. Or you may choose to see a provider with special training in breastfeeding. Examples include:

• Breastfeeding medicine specialist. This is a board-certified physician with advanced training in breastfeeding support. They can diagnose and treat all possible lactation disorders, from nipple blebs to mastitis. They also offer education and support.
• International Board Certified Lactation Consultant (IBCLC®). A lactation consultant can offer clinical care. This includes taking your medical history, learning your child’s feeding history and creating a plan to help.
• Breastfeeding and Lactation Educator or Counselor. This provider offers basic education and counseling. This means they can teach you about breastfeeding and lactation and answer your questions. There are about 20 different roles within this group. These include Certified Breastfeeding Counselor (CBC) and Certified Lactation Educator (CLE).
• Breastfeeding Peer Supporter. This is someone who has experience breastfeeding and wants to use their experience to help you. They offer education and support from a peer’s perspective. Titles you may see include Breastfeeding Peer Counselor (BPC) and La Leche League Leader (LLLL).

Sometimes you don’t need an expert but instead just an extra set of hands. This is where your support network can step in and help. Don’t hesitate to ask your partner or a loved one to be there with you while you breastfeed. They can grab supplies, burp your baby or just keep you company (and awake) when you need a boost.

## Additional Common Questions

**What are some common concerns about breastfeeding?**

For many, there are concerns and worries about specific aspects of breastfeeding. It’s important to remember that all questions are worth asking when it comes to caring for your child. Don’t be afraid to share whatever’s on your mind with your healthcare provider. It’s best that you get the correct information before you make important decisions about breastfeeding.

Some common questions and answers include:

**Are my breasts too small to breastfeed?**

No. Breast size doesn’t affect your ability to breastfeed. The amount of milk your breasts make will depend on your overall health and how much your baby eats.

**Will breastfeeding hurt?**

Breastfeeding shouldn’t hurt. If it does, it might be because your baby isn’t latched onto your breast well. Your healthcare provider can help you learn how to hold your baby and get a good latch. If you still have pain, tell your provider so they can look for other causes.

**Is breastfeeding hard to do?**

Each person’s experience is unique. In general, breastfeeding is a learned skill and takes practice.

You might feel like you need four arms or hands to do it for the first couple of weeks. But learning to breastfeed is a bit like learning how to ride a bike. Reading the instructions can help you understand the basics, but you don’t truly learn how to do it until you’re “hands-on” and start practicing.

Many hospitals offer breastfeeding classes that you can attend during pregnancy. In most cases, nurses and lactation consultants are also available to give you information and support.

**What if I need to be apart from my baby?**

If you need to be away from your baby, you can pump or hand express your milk. Store the milk in the fridge or freezer. The person who’s staying with your baby can feed them from a bottle.

If you’re returning to work, talk to your employer about their policies for pumping breaks. In the U.S., the Fair Labor Standards Act provides you with the right to take breaks for pumping.

Pumping while you’re away from your baby serves two purposes. It allows you to store your milk to give to your baby later. It also helps you keep up your milk supply.

**A note from Cleveland Clinic**

Breastfeeding might become one of your most cherished memories. But that doesn’t mean it always “comes naturally” or is a smooth or easy process. Don’t expect yourself to instantly know how to breastfeed. And resist the urge to blame yourself if things don’t quite go as planned.

Instead, soak up as much knowledge as you can and ask as many questions as you want. Work closely with a healthcare provider who’s specially trained in breastfeeding and lactation. They can teach you how to get started and what to do if you run into issues.
MD
  ],


  [
    'id' => 3,
    'cat' => 'what-is-breastfeeding',
    'title' => 'Breastfeeding is best pero paano nga ba?',
    'author' => 'UNICEF (2023)',
    'thumb' => '/MILKYWAY/public/images/articles/thumbs/unicef-tagalog.jpg', // optional
    'overview' => 'Tagalog guide that explains why breastfeeding matters and gives practical solutions to common challenges like low supply, latching pain, hygiene, work, public feeding, and formula pressure.',
    'source_url' => '',
    'content' => <<<'MD'
## Breastfeeding is Best, Pero Paano Nga ba?
Lutasin ang mga pagsubok sa breastfeeding gamit ang mga subok na paraan.

Iba ang saya ng pagiging isang ina, lalo na kung ikaw ay first-time mom. Pero bukod sa saya, may halong pangamba at takot. Ano nga ba ang best way para maalagaan si baby, lalo na sa pagbe-breast feed?

**Tandaan: Walang makakapantay sa gatas ng isang ina.**

Ang gatas ng ina ang best source ng nutriyson na kailangan ng isang sanggol mula pagkapanganak. Breastfeeding serves as your baby’s first vaccine. Ang breastmilk ay nagbibigay ng nutrients at antibodies na akma para sa sanggol upang ito ay may lakas at laban sa mga impeksyon. Ito ay best sa kanya hanggang siya ay mag-two years old. Bukod sa kalusugan, mas made-develop ang bond mo kay baby.

Napakaimportante ng breastfeeding sa unang 1,000 days ni baby. Ang breastfeeding kasi ay nakakaiwas sa malnutrition at child mortality. At para sa mga nanay, less risk magkaroon ng ovarian o breast cancer, high blood pressure at type 2 diabetes. Sa mabuting pagpapa-breastfeed, hindi lang bawas sa sakit para kay baby at mommy, bawas gastos din, at syempre kapag mas masigla, mas kampante ka na healthy na lumalaki ang iyong anak.

May pitong common breastfeeding challenges na usual na nararanasan ng mga nanay. Narito ang ilan sa mga paraan para maibsan natin ang challenges na ito.

**1. Paano kapag kakaunti lang ang gatas na lumalabas?**

Huwag mangamba kung kaunti lamang ang lumalabas na gatas. Ang tiyan ng bagong silang ay kasing laki lang ng isang calamansi. Ang kanyang tiyan ay unti-unting lalaki sabay ng pagdami ng iyong gatas, kadalasan four days after ng panganganak.

Para sa mga bagong nanay, importante na ang breastfeeding ay magsimula sa unang oras pagkatapos manganak. Ang agarang skin-to-skin contact kasi ay nakakapagdoble ng tyansa ng breastfeeding success.

Mas maganda din na panatilihing eksklusibo ang breastfeeding sa first six months ni baby. Ang ibang pagkain at inumin tulad ng formula milk ay pwedeng maging dahilan ng paghina ng pagbreastfeed ni baby at paghina rin ng paglabas ng gatas. Ituloy tuloy lang ang pagpapasuso upang patuloy ang malakas na daloy ng gatas

**2. Mahirap ba o masakit ang paghakab? **

Maaaring minsan ay may kaunting discomfort, pero sa una lamang ito. Subukan ang iba’t-ibang posisyon para maging maginhawa ang latching. Sa pangmatagalan, dapat wala itong sakit. Para maayos maglatch si baby, siguraduhing malawak ang bukas ng kanyang bibig, ang ibabang labi ay naka-palabas, at nakadikit ang kanyang baba sa iyong suso. Kapag nakuha ang maayos na paglapat, madali nang makukuha ni baby ang gatas, at pareho na kayong giginhawa.

**3. Paano mas maging ligtas at safe ang pagbreastfeed?**

Siguraduhin na palagi kang nag-oobserve ng proper hygiene at naghuhugas ng kamay nang mabuti. Maaari ding gumamit ng alcohol bago at pagkatapos hawakan si baby o kapag hinahawakan at linilinisan ang kanyang mga gamit at paligid. Hindi kailangang hugasan ang iyong dibdib bago mag-breastfeed.

**4. Pwede ba mag-breastfeed kahit magtratrabaho na uli? **

Puwedeng-puwede! Ang trabaho ay hindi hadlang para mabigyan ng tamang nutrisyon si baby. Mahalaga na tuloy-tuloy lang ang breastfeeding.

Bago bumalik, kausapin ang iyong supervisor o nararapat na HR officer ukol sa oras na kailangan at lugar para makapag-express ng gatas. Ayon sa Expanded Breastfeeding Promotion Act of 2009 (RA 10028), ang mga breastfeeding mom na nagtratrabaho ay may karagdagang  40 minutes lactation break para kumolekta ng gatas during work hours, at dapat bayad na oras ito. Nakasaad din sa batas na lahat ng pinagtatrabahuhan ay kailangan maglaan ng lactation rooms para sa mga manggagawang ina.

Subukan rin humanap ng panahon pagkagising o pagkatapos ng trabaho para makaimbak ng gatas. Nakakatulong din na may suporta ng iyong pamilya upang ikaw ay maka-focus sa pagkuha ng gatas. Sa lugar na pinagtatrabahuan, siguraduhing may support sa iyong mga ka-trabaho. 

**5. Hindi ba nakakahiya mag-breastfeed in public?**

Hindi. Ang pag-breastfeed ay isang natural na bahagi ng pagiging ina at isang natural na pagkain ng isang sanggol. Kapag nasa labas, huwag paabutin na umiiyak si baby bago i-breastfeed, dahil makakasama ito sa paghubog ng kanyang pangangatawan. 

Ang mga nanay ay maaaring magpa-breastfeed sa kahit anong lugar. May karapatan tayong maghanap ng ligtas at malinis na lugar na nakalaan para sa breastfeeding sa ating mga opisina at mga lugar na pampubliko. Suportado ito ng Expanded Breastfeeding Act at ng Safe Spaces Act, kaya kapag may pambabastos, pwede rin itong i-report. Parating isipin ang kapakanan ninyong mag-ina.

**6. Paano kapag may pressure na gumamit ng formula milk?**

Sapat, ligtas, at mas masustanya ang breastmilk para sa mga baby mula 0-6 months. Hindi kailangang gumamit ng formula, powder o bottled milk para sa kanya, lalo na sa unang six months niya. Ang breastmilk substitutes—kasama din ang am o rice water—ay posibleng may dalang health risks para sa mga sanggol.

**7. Ang breastfeeding ba ay sakin lang nakasalalay?**

Hindi. Napakaimportante ng iyong buong pamilya sa panahon na ito. Hikayatin ang pamilya lalo na ng mga tatay, na tumulong at sumoporta. Ganun din sa ating place of work. May mga nakatakdang lugar at oras para sa pag express ng breastmilk, at ang support ng ating mga katrabaho ay importante rin. Mag tanong sa inyong komunidad, kadalasan ay may mga organized na breastfeeding counsellors or support groups na pwede magbigay ng payo sa mga nagpapasusong nanay.

Ang gatas ng ina ay walang katulad at mas madali ito na nanamnam ni baby, kaya rin naman madalas mag-breastfeed ang babies.


MD
  ],

  [
    'id' => 4,
    'cat' => 'what-is-breastfeeding',
    'title' => 'Making Breastfeeding possible for mothers in every community',
    'author' => 'UNICEF (2025)',
    'thumb' => '/MILKYWAY/public/images/articles/thumbs/unicef-tagalog.jpg', // optional
    'overview' => 'Tagalog guide that explains why breastfeeding matters and gives practical solutions to common challenges like low supply, latching pain, hygiene, work, public feeding, and formula pressure.',
    'source_url' => '',
    'content' => <<<'MD'
## Making breastfeeding possible for mothers in every community
For every child, sustainable support

In the upland barangay of Tabon, Dalaguete, Cebu, Moya Janessa Lachica breastfeeds her newborn daughter, Marinelle Jane, in the same home where her family grows vegetables and raises livestock. She lives far from town, but when it was time to give birth, she travelled to the nearest health center. It was there, through regular antenatal visits, that she learned how facility-based delivery could help protect her and her baby—and how exclusive breastfeeding in the first six months could give her child a stronger start in life. Breastmilk, she learned, is more than nourishment. It builds immunity, supports healthy growth, and reduces the risk of disease during the most critical first 1,000 days.

In remote communities like Tabon, where food prices can quickly change and roads can become impassable during storms, breastfeeding provides steady nourishment when other options are out of reach. Moya received early counselling from her barangay nutrition scholar and continued support from her mother and partner, who help with caregiving and household meals. These layers of support—at home and in the community—have made it easier for her to focus on her baby’s nutrition.

Moya’s story shows how consistent support—at home, in the community, and through policy—can make it possible for mothers to continue breastfeeding, even in challenging settings. More research now shows it can also protect the environment. When counselling is available, and policies to protect breastfeeding enforced, and families are not left to navigate feeding decisions alone, children are more likely to receive the care and nutrition they need from the very beginning. 

Breastfeeding is one of the most effective ways to protect a child’s health. Upholding it means ensuring every mother has what she needs—and every child is given the best possible start.
MD
  ],

  [
    'id' => 5,
    'cat' => 'problems',
    'title' => '5 common breastfeeding problems',
    'author' => 'UNICEF. (2023).',
    'thumb' => '/MILKYWAY/public/images/articles/thumbs/unicef-tagalog.jpg', // optional
    'overview' => 'Tagalog guide that explains why breastfeeding matters and gives practical solutions to common challenges like low supply, latching pain, hygiene, work, public feeding, and formula pressure.',
    'source_url' => '',
    'content' => <<<'MD'
## 5 common breastfeeding problems
For every child, sustainable support

In the upland barangay of Tabon, Dalaguete, Cebu, Moya Janessa Lachica breastfeeds her newborn daughter, Marinelle Jane, in the same home where her family grows vegetables and raises livestock. She lives far from town, but when it was time to give birth, she travelled to the nearest health center. It was there, through regular antenatal visits, that she learned how facility-based delivery could help protect her and her baby—and how exclusive breastfeeding in the first six months could give her child a stronger start in life. Breastmilk, she learned, is more than nourishment. It builds immunity, supports healthy growth, and reduces the risk of disease during the most critical first 1,000 days.

In remote communities like Tabon, where food prices can quickly change and roads can become impassable during storms, breastfeeding provides steady nourishment when other options are out of reach. Moya received early counselling from her barangay nutrition scholar and continued support from her mother and partner, who help with caregiving and household meals. These layers of support—at home and in the community—have made it easier for her to focus on her baby’s nutrition.

Moya’s story shows how consistent support—at home, in the community, and through policy—can make it possible for mothers to continue breastfeeding, even in challenging settings. More research now shows it can also protect the environment. When counselling is available, and policies to protect breastfeeding enforced, and families are not left to navigate feeding decisions alone, children are more likely to receive the care and nutrition they need from the very beginning. 

Breastfeeding is one of the most effective ways to protect a child’s health. Upholding it means ensuring every mother has what she needs—and every child is given the best possible start.
MD
  ],
];


/* =========================================================
   3) SAFE MINI-MARKDOWN RENDERER
   Supports:
   - ## Heading (h2), ### Heading (h3)
   - - bullet list
   - blank lines = paragraph breaks
   - [text](url) links (http/https only)
   - **bold**, *italic*
   ========================================================= */

function render_article_content(string $md): string
{
  $md = str_replace(["\r\n", "\r"], "\n", $md);
  $lines = explode("\n", $md);

  $html = '';
  $inList = false;
  $paragraph = '';

  $flushParagraph = function () use (&$html, &$paragraph) {
    $p = trim($paragraph);
    if ($p !== '') {
      $html .= '<p>' . render_inline($p) . "</p>\n";
    }
    $paragraph = '';
  };

  $flushList = function () use (&$html, &$inList) {
    if ($inList) {
      $html .= "</ul>\n";
      $inList = false;
    }
  };

  foreach ($lines as $rawLine) {
    $line = trim($rawLine);

    // blank line
    if ($line === '') {
      $flushParagraph();
      $flushList();
      continue;
    }

    // headings
    if (str_starts_with($line, '### ')) {
      $flushParagraph();
      $flushList();
      $html .= '<h3>' . render_inline(substr($line, 4)) . "</h3>\n";
      continue;
    }

    if (str_starts_with($line, '## ')) {
      $flushParagraph();
      $flushList();
      $html .= '<h2>' . render_inline(substr($line, 3)) . "</h2>\n";
      continue;
    }

    // dash list
    if (preg_match('/^\-\s+(.+)$/u', $line, $m)) {
      $flushParagraph();
      if (!$inList) {
        $html .= "<ul>\n";
        $inList = true;
      }
      $html .= '<li>' . render_inline($m[1]) . "</li>\n";
      continue;
    }

    // bullet list (•)
    if (preg_match('/^•\s*(.+)$/u', $line, $m)) {
      $flushParagraph();
      if (!$inList) {
        $html .= "<ul>\n";
        $inList = true;
      }
      $html .= '<li>' . render_inline($m[1]) . "</li>\n";
      continue;
    }

    // normal paragraph
    $flushList();
    if ($paragraph !== '') $paragraph .= ' ';
    $paragraph .= $line;
  }

  $flushParagraph();
  $flushList();
  return $html;
}


function render_inline(string $text): string
{
  // Escape first (XSS protection)
  $safe = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

  // Bold: **text**
  $safe = preg_replace('/\*\*(.+?)\*\*/u', '<strong>$1</strong>', $safe);

  // Italic: *text*
  $safe = preg_replace('/(?<!\*)\*(?!\s)(.+?)(?<!\s)\*(?!\*)/u', '<em>$1</em>', $safe);

  // Links: [text](url)
  $safe = preg_replace_callback('/\[(.+?)\]\((.+?)\)/u', function ($m) {
    if (!preg_match('#^https?://#i', $m[2])) return $m[1];
    $url = htmlspecialchars($m[2], ENT_QUOTES, 'UTF-8');
    return '<a href="' . $url . '" target="_blank" rel="noopener noreferrer">' . $m[1] . '</a>';
  }, $safe);

  return $safe;
}
