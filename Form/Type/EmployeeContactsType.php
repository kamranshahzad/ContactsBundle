<?php

namespace Cogilent\ContactsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Intl\Intl;


class EmployeeContactsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $contactTypes = array('u'=>'Unspecified' ,'c' => 'Cell', 'l' => 'Landline', 'o' => 'Office', 'h' => 'Home'  );

        $defaultOptions = array(
            'multiple'=>false,
            'expanded'=>true ,
            'choice_list' => new SimpleChoiceList($contactTypes),
            'data'=> 'u'
        );


        $countries = array(
            '0' => 'Choose Country Code',
            '+7840' =>  'Abkhazia (+7 840)',
            '+7940' =>  'Abkhazia (+7 940)',
            '+93' =>  'Afghanistan (+93)',
            '+355' =>  'Albania (+355)',
            '+213' =>  'Algeria (+213)',
            '+1684' =>  'American Samoa (+1 684)',
            '+376' =>  'Andorra (+376)',
            '+244' =>  'Angola (+244)',
            '+1264' =>  'Anguilla (+1 264)',
            '+1268' =>  'Antigua and Barbuda (+1 268)',
            '+54' =>  'Argentina (+54)',
            '+374' =>  'Armenia (+374)',
            '+297' =>  'Aruba (+297)',
            '+247' =>  'Ascension (+247)',
            '+61' =>  'Australia (+61)',
            '+672' =>  'Australian External Territories (+672)',
            '+43' =>  'Austria (+43)',
            '+994' =>  'Azerbaijan (+994)',
            '+1242' =>  'Bahamas (+1 242)',
            '+973' =>  'Bahrain (+973)',
            '+880' =>  'Bangladesh (+880)',
            '+1246' =>  'Barbados (+1 246)',
            '+1268' =>  'Barbuda (+1 268)',
            '+375' =>  'Belarus (+375)',
            '+32' =>  'Belgium (+32)',
            '+501' =>  'Belize (+501)',
            '+229' =>  'Benin (+229)',
            '+1441' =>  'Bermuda (+1 441)',
            '+975' =>  'Bhutan (+975)',
            '+591' =>  'Bolivia (+591)',
            '+387' =>  'Bosnia and Herzegovina (+387)',
            '+267' =>  'Botswana (+267)',
            '+55' =>  'Brazil (+55)',
            '+246' => 'British Indian Ocean Territory (+246)',
            '+1284' =>  'British Virgin Islands (+1 284)',
            '+673' =>  'Brunei (+673)',
            '+359' =>  'Bulgaria (+359)',
            '+226' =>  'Burkina Faso (+226)',
            '+257' =>  'Burundi (+257)',
            '+855' =>  'Cambodia (+855)',
            '+237' =>  'Cameroon (+237)',
            '+1' =>  'Canada (+1)',
            '+238' =>  'Cape Verde (+238)',
            '+345' =>  'Cayman Islands (+ 345)',
            '+236' =>  'Central African Republic (+236)',
            '+235' =>  'Chad (+235)',
            '+56' =>  'Chile (+56)',
            '+86' =>  'China (+86)',
            '+61' =>  'Christmas Island (+61)',
            '+61' =>  'Cocos-Keeling Islands (+61)',
            '+57' =>  'Colombia (+57)',
            '+269' =>  'Comoros (+269)',
            '+242' =>  'Congo (+242)',
            '+243' =>  'Congo, Dem. Rep. of (Zaire) (+243)',
            '+682' =>  'Cook Islands (+682)',
            '+506' =>  'Costa Rica (+506)',
            '+225' =>  'Ivory Coast (+225)',
            '+385' =>  'Croatia (+385)',
            '+53' =>  'Cuba (+53)',
            '+599' =>  'Curacao (+599)',
            '+537' =>  'Cyprus (+537)',
            '+420' =>  'Czech Republic (+420)',
            '+45' =>  'Denmark (+45)',
            '+246' =>  'Diego Garcia (+246)',
            '+253' =>  'Djibouti (+253)',
            '+1767' =>  'Dominica (+1 767)',
            '+1809' =>  'Dominican Republic (+1 809)',
            '+1829' =>  'Dominican Republic (+1 829)',
            '+1849' =>  'Dominican Republic (+1 849)',
            '+670' =>  'East Timor (+670)',
            '+56' =>  'Easter Island (+56)',
            '+593' =>  'Ecuador (+593)',
            '+20' =>  'Egypt (+20)',
            '+503' =>  'El Salvador (+503)',
            '+240' =>  'Equatorial Guinea (+240)',
            '+291' =>  'Eritrea (+291)',
            '+372' =>  'Estonia (+372)',
            '+251' =>  'Ethiopia (+251)',
            '+500' =>  'Falkland Islands (+500)',
            '+298' =>  'Faroe Islands (+298)',
            '+679' =>  'Fiji (+679)',
            '+358' =>  'Finland (+358)',
            '+33' =>  'France (+33)',
            '+596' =>  'French Antilles (+596)',
            '+594' =>  'French Guiana (+594)',
            '+689' =>  'French Polynesia (+689)',
            '+241' =>  'Gabon (+241)',
            '+220' =>  'Gambia (+220)',
            '+995' =>  'Georgia (+995)',
            '+49' =>  'Germany (+49)',
            '+233' =>  'Ghana (+233)',
            '+350' =>  'Gibraltar (+350)',
            '+30' =>  'Greece (+30)',
            '+299' =>  'Greenland (+299)',
            '+1473' =>  'Grenada (+1 473)',
            '+590' =>  'Guadeloupe (+590)',
            '+1671' =>  'Guam (+1 671)',
            '+502' =>  'Guatemala (+502)',
            '+224' =>  'Guinea (+224)',
            '+245' =>  'Guinea-Bissau (+245)',
            '+595' =>  'Guyana (+595)',
            '+509' =>  'Haiti (+509)',
            '+504' =>  'Honduras (+504)',
            '+852' =>  'Hong Kong SAR China (+852)',
            '+36' =>  'Hungary (+36)',
            '+354' =>  'Iceland (+354)',
            '+91' =>  'India (+91)',
            '+62' =>  'Indonesia (+62)',
            '+98' =>  'Iran (+98)',
            '+964' =>  'Iraq (+964)',
            '+353' =>  'Ireland (+353)',
            '+972' =>  'Israel (+972)',
            '+39' =>  'Italy (+39)',
            '+1876' =>  'Jamaica (+1 876)',
            '+81' =>  'Japan (+81)',
            '+962' =>  'Jordan (+962)',
            '+77' =>  'Kazakhstan (+7 7)',
            '+254' =>  'Kenya (+254)',
            '+686' =>  'Kiribati (+686)',
            '+850' =>  'North Korea (+850)',
            '+82' =>  'South Korea (+82)',
            '+965' =>  'Kuwait (+965)',
            '+996' =>  'Kyrgyzstan (+996)',
            '+856' =>  'Laos (+856)',
            '+371' =>  'Latvia (+371)',
            '+961' =>  'Lebanon (+961)',
            '+266' =>  'Lesotho (+266)',
            '+231' =>  'Liberia (+231)',
            '+218' =>  'Libya (+218)',
            '+423' =>  'Liechtenstein (+423)',
            '+370' =>  'Lithuania (+370)',
            '+352' =>  'Luxembourg (+352)',
            '+853' =>  'Macau SAR China (+853)',
            '+389' =>  'Macedonia (+389)',
            '+261' =>  'Madagascar (+261)',
            '+265' =>  'Malawi (+265)',
            '+60' =>  'Malaysia (+60)',
            '+960' =>  'Maldives (+960)',
            '+223' =>  'Mali (+223)',
            '+356' =>  'Malta (+356)',
            '+692' =>  'Marshall Islands (+692)',
            '+596' =>  'Martinique (+596)',
            '+222' =>  'Mauritania (+222)',
            '+230' =>  'Mauritius (+230)',
            '+262' =>  'Mayotte (+262)',
            '+52' =>  'Mexico (+52)',
            '+691' =>  'Micronesia (+691)',
            '+1808' =>  'Midway Island (+1 808)',
            '+691' =>  'Micronesia (+691)',
            '+373' =>  'Moldova (+373)',
            '+377' =>  'Monaco (+377)',
            '+976' =>  'Mongolia (+976)',
            '+382' =>  'Montenegro (+382)',
            '+1664' =>  'Montserrat (+1664)',
            '+212' =>  'Morocco (+212)',
            '+95' =>  'Myanmar (+95)',
            '+264' =>  'Namibia (+264)',
            '+674' =>  'Nauru (+674)',
            '+977' =>  'Nepal (+977)',
            '+31' =>  'Netherlands (+31)',
            '+599' =>  'Netherlands Antilles (+599)',
            '+1869' =>  'Nevis (+1 869)',
            '+687' =>  'New Caledonia (+687)',
            '+64' =>  'New Zealand (64)',
            '+505' =>  'Nicaragua (+505)',
            '+227' =>  'Niger (+227)',
            '+234' =>  'Nigeria (+234)',
            '+683' =>  'Niue (+683)',
            '+672' =>  'Norfolk Island (+672)',
            '+1670' =>  'Northern Mariana Islands (+1 670)',
            '+47' =>  'Norway (+47)',
            '+968' =>  'Oman (+968)',
            '+92' =>  'Pakistan (+92)',
            '+680' =>  'Palau (+680)',
            '+970' =>  'Palestinian Territory (+970)',
            '+507' =>  'Panama (+507)',
            '+675' =>  'Papua New Guinea (+675)',
            '+595' =>  'Paraguay (+595)',
            '+51' =>  'Peru (+51)',
            '+63' =>  'Philippines (+63)',
            '+48' =>  'Poland (+48)',
            '+351' =>  'Portugal (+351)',
            '+1787' =>  'Puerto Rico (+1 787)',
            '+1939' =>  'Puerto Rico (+1 939)',
            '+974' =>  'Qatar (+974)',
            '+262' =>  'Reunion (+262)',
            '+40' =>  'Romania (+40)',
            '+7' =>  'Russia (+7)',
            '+250' =>  'Rwanda (+250)',
            '+685' =>  'Samoa (+685)',
            '+378' =>  'San Marino (+378)',
            '+966' =>  'Saudi Arabia (+966)',
            '+221' =>  'Senegal (+221)',
            '+381' =>  'Serbia (+381)',
            '+248' =>  'Seychelles (+248)',
            '+232' =>  'Sierra Leone (+232)',
            '+65' =>  'Singapore (+65)',
            '+421' =>  'Slovakia (+421)',
            '+386' =>  'Slovenia (+386)',
            '+677' =>  'Solomon Islands (+677)',
            '+27' =>  'South Africa (+27)',
            '+500' =>  'South Georgia and the South Sandwich Islands (+500)',
            '+34' =>  'Spain (+34)',
            '+94' =>  'Sri Lanka (+94)',
            '+249' =>  'Sudan (+249)',
            '+597' =>  'Suriname (+597)',
            '+268' =>  'Swaziland (+268)',
            '+46' =>  'Sweden (+46)',
            '+41' =>  'Switzerland (+41)',
            '+963' =>  'Syria (+963)',
            '+886' =>  'Taiwan (+886)',
            '+992' =>  'Tajikistan (+992)',
            '+255' =>  'Tanzania (+255)',
            '+66' =>  'Thailand (+66)',
            '+670' =>  'Timor Leste (+670)',
            '+228' =>  'Togo (+228)',
            '+690' =>  'Tokelau (+690)',
            '+676' =>  'Tonga (+676)',
            '+1868' =>  'Trinidad and Tobago (+1 868)',
            '+216' =>  'Tunisia (+216)',
            '+90' =>  'Turkey (+90)',
            '+993' =>  'Turkmenistan (+993)',
            '+1649' =>  'Turks and Caicos Islands (+1 649)',
            '+688' =>  'Tuvalu (+688)',
            '+256' =>  'Uganda (+256)',
            '+380' =>  'Ukraine (+380)',
            '+971' =>  'United Arab Emirates (+971)',
            '+44' =>  'United Kingdom (+44)',
            '+1' =>  'United States (+1)',
            '+598' =>  'Uruguay (+598)',
            '+1340' =>  'U.S. Virgin Islands (+1 340)',
            '+998' =>  'Uzbekistan (+998)',
            '+678' =>  'Vanuatu (+678)',
            '+58' =>  'Venezuela (+58)',
            '+84' =>  'Vietnam (+84)',
            '+1808' =>  'Wake Island (+1 808)',
            '+681' =>  'Wallis and Futuna (+681)',
            '+967' =>  'Yemen (+967)',
            '+260' =>  'Zambia (+260)',
            '+255' =>  'Zanzibar (+255)',
            '+263' =>  'Zimbabwe (+263)'
        );


        $builder->add('numberType','choice', $defaultOptions );

        $builder->add('officeExtension','text',array(
            'label'=>false,
            'required'=>false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder'=>'Ext'
            ),
        ));

        $builder->add('phoneNumber','text',array(
            'label'=>false,
            'required'=>false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder'=>'Phone Number'
            ),
        ));

        $builder->add('countryCode','choice',array(
            'choices' => $countries,
            'required'=>false,
            'data'=> '0',
            'attr' => array(
                'class' => 'form-control',
            ),
        ));

    }


    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Cogilent\ContactsBundle\Entity\EmployeeContacts',
        ));
    }


    public function getName()
    {
        return 'contact_form';
    }

    public function getParent()
    {
        return 'form';
    }
}
