<fieldset><legend>Create a Slot</legend>
    <form action="slots.php" method="post">
    <p>Enter the details of the slot you want to create.</p>
    <dl>
        <dt><label>Start Time <small>(24-hour HH:MM)</small></label></dt>
        <dd>
            <input class="mono" type="text" name="start_time_h" size="2" />&nbsp;:
            <input class="mono" type="text" name="start_time_m" size="2" />
        </dd>
    </dl><dl>
        <dt><label>End Time <small>(24-hour HH:MM)</small></label></dt>
        <dd>
            <input class="mono" type="text" name="end_time_h" size="2" />&nbsp;:
            <input class="mono" type="text" name="end_time_m" size="2" />
        </dd>
    </dl><dl>
        <dt><label>Days <small>Check All</small></label></dt>
        <dd>
            <!-- REPLACE WITH A LOOP FROM DATABASE -->
            <table>
                <tr>
                    <th>M</th>
                    <th>T</th>
                    <th>W</th>
                    <th>T</th>
                    <th>F</th>
                    <th>S</th>
                    <th>S</th>
                </tr><tr>
                    <td><input type="checkbox" name="days[M]" value="Mon" /></td>
                    <td><input type="checkbox" name="days[T]" value="Tue" /></td>
                    <td><input type="checkbox" name="days[W]" value="Wed" /></td>
                    <td><input type="checkbox" name="days[T]" value="Thu" /></td>
                    <td><input type="checkbox" name="days[F]" value="Fri" /></td>
                    <td><input type="checkbox" name="days[S]" value="Sat" /></td>
                    <td><input type="checkbox" name="days[S]" value="Sun" /></td>
                </tr>
            </table>
        </dd>
    </dl><dl>
        <dd><input type="submit" value="Create Slot" name="submit" /></dd>
    </dl>
    </form>
</fieldset>
