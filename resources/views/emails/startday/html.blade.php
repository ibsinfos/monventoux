
                <p style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.5;color: #051539;text-align: left;">Hoi {{$name}}</p>

                <p style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.5;color: #051539;text-align: left;">We hebben je aanmelding voor de startdag ontvangen.<br/>Mocht er een fout zijn gemaakt. Laat het dan zo snel mogelijk weten via
                    <a href="mailto:info@monventoux.be" target="_blank"
                       style="font-family: Helvetica, Arial, sans-serif;color: #F63E3D;text-decoration: underline;">info@monventoux.be</a>.
                </p>

                <p style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.5;color: #051539;text-align: left;">
                    <strong>De door jou gekozen opties:</strong></p>
                <ul>
                    @foreach($options as $option)
                        <li style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.5;color: #051539;text-align: left;">{{$option}}</li>
                    @endforeach
                </ul>

                <p style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.5;color: #051539;text-align: left;">
                    <strong> Locatiegegevens:</strong></p>

                @foreach($locations as $location)
                    <p style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.5;color: #051539;text-align: left;">{{$location['date']}}<br/> {{$location['name']}}<br/> {{$location['address']}}<br/> {{$location['city']}}</p>
                @endforeach

                <p style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.5;color: #051539;text-align: left;">Tot ziens op {{$chosendate}}!</p>
            </td>
        </tr>
        </tbody>
    </table>
</center>
