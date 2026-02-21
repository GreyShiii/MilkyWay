<?php
require_once __DIR__ . '/lang.php';
require_once __DIR__ . '/formatter.php';

function didyouknow_sections()
{
  $sections = [

    [
      'slug' => 'trivia',
      'title' => [
        'en'  => 'Trivia',
        'fil' => 'Kaalaman',
      ],
      'image' => 'public/images/didyouknow/trivia.jpg',
      'ribbon_class' => 'ribbon-pink',
      'link' => 'index.php?page=didyouknow_cat&cat=trivia',

      'facts' => [

        'en' => [
          "**Did you know?** Breastfeeding protects your baby from ear infections, diarrhoea, pneumonia and other childhood diseases.",
          "**Did you know?** Breastfeeding protects the mother from diabetes, breast and ovarian cancers, heart disease and postpartum depression.",
          "**Did you know?** The ‘first milk’ – or colostrum – is rich in antibodies and gives newborns an immunity boost while their own immune systems are still developing.",
          "**Did you know?** Newborns have a strong sense of smell and know the unique scent of your breastmilk. That is why your baby will turn his or her head to you when he or she is hungry.",
          "**Did you know?** Babies are born extremely nearsighted, which means they can only see things about eight to 15 inches away. That also happens to be the distance between your face and your baby's face when breastfeeding.",
          "**Did you know?** The hormones released when you breastfeed help your uterus shrink back to its pre-pregnancy size.",
          "**Did you know?** Breastfeeding helps lower the risk of breast cancer and ovarian cancer in moms. Breastfeeding may also help you to lose weight. Mothers who exclusively breastfeed can burn as many as 600 calories a day, which may help you get back to your pre-pregnancy weight.",
          "**Did you know?** After you give birth, your body gets the final signal to make milk. Your supply then regulates to meet your baby’s needs.",
          "**Did you know?** Breastmilk produces yellowish fluid (Liquid Gold) called colostrum filled with nutrients and antibodies.",
          "**Did you know?** Early milk may look watery but later becomes thicker and fattier for healthy growth.",
          "**Did you know?** Breastmilk helps fight infection and reduce swelling in the breast.",
          "",
          "**Reference:**",
          "https://www.unicef.org/parenting/food-nutrition/14-myths-about-breastfeeding",
        ],

        'fil' => [
          "**Alam mo ba?** Pinoprotektahan ng pagpapasuso ang iyong sanggol laban sa impeksiyon sa tainga, pagtatae, pulmonya, at iba pang sakit sa pagkabata.",
          "**Alam mo ba?** Pinoprotektahan din ng pagpapasuso ang ina laban sa diabetes, kanser sa suso at obaryo, sakit sa puso, at postpartum depression.",
          "**Alam mo ba?** Ang unang gatas o colostrum ay mayaman sa antibodies at nagbibigay ng dagdag na proteksiyon sa bagong silang habang hindi pa ganap ang kanilang immune system.",
          "**Alam mo ba?** May malakas na pang-amoy ang mga bagong silang at nakikilala ang amoy ng gatas ng kanilang ina.",
          "**Alam mo ba?** Malabo ang paningin ng mga sanggol at nakakakita lamang ng mga bagay na walong hanggang labinlimang pulgada ang layo.",
          "**Alam mo ba?** Ang mga hormone habang nagpapasuso ay tumutulong ibalik ang matris sa dati nitong laki.",
          "**Alam mo ba?** Nakababawas ang pagpapasuso sa panganib ng kanser at nakatutulong sa pagbawas ng timbang.",
          "**Alam mo ba?** Pagkatapos manganak, nag-aadjust ang produksyon ng gatas ayon sa pangangailangan ng sanggol.",
          "**Alam mo ba?** Ang colostrum o 'Liquid Gold' ay puno ng sustansya at antibodies.",
          "**Alam mo ba?** Ang unang gatas ay maaaring manipis ngunit nagiging mas malapot para sa paglaki ng sanggol.",
          "**Alam mo ba?** Nakakatulong ang gatas ng ina laban sa impeksiyon at pamamaga.",
          "",
          "**Sanggunian:**",
          "https://www.unicef.org/parenting/food-nutrition/14-myths-about-breastfeeding",
        ],
      ],
    ],

    [
      'slug' => 'facts-myths',
      'title' => [
        'en'  => 'Facts & Myths',
        'fil' => 'Katotohanan at Mito',
      ],
      'image' => 'public/images/didyouknow/myths.jpg',
      'ribbon_class' => 'ribbon-red',
      'link' => 'index.php?page=didyouknow_cat&cat=facts-myths',

      'facts' => [

        'en' => [
          "**1. Myth:** Breastfeeding is easy.",
          "**Fact:** Breastfeeding takes time and practice for both mother and baby.",
          "**2. Myth:** It’s normal for breastfeeding to hurt.",
          "**Fact:** Proper positioning can prevent nipple pain.",
          "**3. Myth:** You must wash nipples before feeding.",
          "**Fact:** Washing is not necessary; natural bacteria help baby’s immunity.",
          "**4. Myth:** Mother and baby should be separated after birth.",
          "**Fact:** Skin-to-skin contact helps establish breastfeeding.",
          "**5. Myth:** Only plain food should be eaten.",
          "**Fact:** Mothers need a balanced diet.",
          "**6. Myth:** Exercise changes milk taste.",
          "**Fact:** Exercise does not affect milk taste.",
          "**7. Myth:** If you don’t start immediately, you can’t breastfeed.",
          "**Fact:** Breastfeeding can still be established later.",
          "**8. Myth:** You cannot use formula at all.",
          "**Fact:** Some mothers combine formula and breastfeeding.",
          "**9. Myth:** Many mothers cannot produce enough milk.",
          "**Fact:** Most mothers produce enough milk with proper support.",
          "**10. Myth:** Sick mothers should stop breastfeeding.",
          "**Fact:** In many cases, breastfeeding can continue.",
          "**11. Myth:** You can’t take medication.",
          "**Fact:** Many medications are safe with medical guidance.",
          "**12. Myth:** Breastfed babies are clingy.",
          "**Fact:** All babies are different.",
          "**13. Myth:** It’s hard to wean after one year.",
          "**Fact:** Breastfeeding up to two years has benefits.",
          "**14. Myth:** Returning to work means stopping breastfeeding.",
          "**Fact:** Many mothers continue breastfeeding after returning to work.",
          "",
          "**Reference:**",
          "https://www.unicef.org/parenting/food-nutrition/14-myths-about-breastfeeding",
        ],

        'fil' => [
          "**1. Mito:** Madali ang pagpapasuso.",
          "**Katotohanan:** Nangangailangan ito ng oras at pagsasanay.",
          "**2. Mito:** Normal na masakit ang pagpapasuso.",
          "**Katotohanan:** Maaaring maiwasan ang sakit sa tamang pagpoposisyon.",
          "**3. Mito:** Kailangang hugasan ang utong bago magpasuso.",
          "**Katotohanan:** Hindi ito kinakailangan.",
          "**4. Mito:** Dapat paghiwalayin ang ina at sanggol.",
          "**Katotohanan:** Mahalaga ang skin-to-skin contact.",
          "**5. Mito:** Plain na pagkain lang ang dapat kainin.",
          "**Katotohanan:** Kailangan ang balanseng diyeta.",
          "**6. Mito:** Naaapektuhan ng ehersisyo ang lasa ng gatas.",
          "**Katotohanan:** Hindi ito naaapektuhan.",
          "**7. Mito:** Hindi na makakapagpasuso kung hindi agad nasimulan.",
          "**Katotohanan:** Maaari pa ring maitaguyod ang pagpapasuso.",
          "**8. Mito:** Hindi maaaring gumamit ng formula.",
          "**Katotohanan:** Maaaring pagsamahin ang formula at pagpapasuso.",
          "**9. Mito:** Hindi sapat ang gatas ng maraming ina.",
          "**Katotohanan:** Karamihan ay may sapat na produksyon.",
          "**10. Mito:** Dapat itigil ang pagpapasuso kapag may sakit.",
          "**Katotohanan:** Madalas ay maaaring magpatuloy.",
          "**11. Mito:** Hindi maaaring uminom ng gamot.",
          "**Katotohanan:** Maraming gamot ang ligtas sa payo ng doktor.",
          "**12. Mito:** Nagiging clingy ang mga pinasusong sanggol.",
          "**Katotohanan:** Lahat ng sanggol ay magkakaiba.",
          "**13. Mito:** Mahirap mag-wean pagkatapos ng isang taon.",
          "**Katotohanan:** May benepisyo ang pagpapasuso hanggang dalawang taon.",
          "**14. Mito:** Kailangang itigil ang pagpapasuso kapag bumalik sa trabaho.",
          "**Katotohanan:** Maraming ina ang nagpapatuloy sa pagpapasuso.",
          "",
          "**Sanggunian:**",
          "https://www.unicef.org/parenting/food-nutrition/14-myths-about-breastfeeding",
        ],
      ],
    ],
  ];

  foreach ($sections as &$sec) {

    $sec['title_text'] = tr($sec['title']);

    $factsRaw = $sec['facts'][lang()] ?? $sec['facts']['en'] ?? [];
    if (!is_array($factsRaw)) $factsRaw = [];

    $sec['facts_html'] = format_facts($factsRaw);
  }

  unset($sec);

  return $sections;
}
