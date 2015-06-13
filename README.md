# falsomaps

To generate entities from the DB (Windoze):

 * ```vendor\bin\doctrine-module orm:convert-mapping --namespace="Maps\Entity\\" --force  --from-database annotation ./module/Maps/src/```
 * ```vendor\bin\doctrine-module orm:generate-entities ./module/Maps/src/ --generate-annotations=true```
