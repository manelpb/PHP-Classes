<?php

class NiceDateException extends Exception {}

/**
 * Make dates pretty!
 *
 * @author Andre Zavala <azavala@tampadesign.net>
 * @link http://tampadesign.net
 * @todo Add more functionality!
 */
class NiceDate
{	
	/**
	 * Get the difference between 2 dates and return a nicely formatted string
	 *
	 * @param string $start
	 * @param string $end
	 * @param boolean $format_interval
	 * @return string
	 */
	public static function get_difference($start = 'now', $end = 'now', $formatInterval = true)
	{
		// Set up dates for comparison
		$startDate = ($start == 'now') ? date('Y-m-d', time()) : $start;
		$endDate = ($end == 'now') ? date('Y-m-d', time()) : $end;
		
		// New DateTime instances with comparison dates
		$startDateObject = new DateTime($startDate);
		$endDateObject = new DateTime($endDate);
		
		// Calculate difference
		$interval = $startDateObject->diff($endDateObject);
		
		// Return result, format if $format_intveral is (bool) true
		return ($formatInterval === true) ? static::format_interval_diff($interval) : $interval;
	}
	
	/**
	 * Simple helper to format a date
	 *
	 * @param string $format
	 * @param string $date_to_format
	 * @return string
	 */
	public static function format($format = 'F j, Y, g:i a', $dateToFormat = 'now')
	{
		$date = new DateTime($dateToFormat);
		return $date->format($format);
	}
	
	/**
	 * Render out a text string interval (e.g. 20 Seconds)
	 *
	 * @param object $interval (DateTime)
	 * @throws NiceDateException
	 * @return string
	 */
	public static function format_interval_diff(DateTime $interval)
	{
		// Result storage
		$formattedDate = null;

		// Year(s)?
		if ($interval->y > 0)
		{
			$formattedDate = $interval->y . ($interval->y > 1) ? ' years' : ' year';
		}
		elseif ($interval->m > 0) // Month(s)?
		{
			$formattedDate = $interval->m . ($interval->m > 1) ? ' months' : ' month';
		}
		elseif ($interval->d > 0) // Day(s)?
		{
			$formattedDate = $interval->d . ($interval->d > 1) ? ' days' : ' day';
		}
		elseif ($interval->h > 0) // Hour(s)?
		{
			$formattedDate = $interval->h . ($interval->h > 1) ? ' hours' : ' hour';
		}
		elseif ($interval->i > 0) // Minute(s)?
		{
			$formattedDate = $interval->i . ($interval->i > 1) ? ' minutes' : ' minute';
		}
		elseif ($interval->s > 0) // Second(s)?
		{
			$formattedDate = $interval->s . ($interval->s > 1) ? ' seconds' : ' second';
		}
		else
		{
			throw new NiceDateException('Invalid interval difference.');
		}
		
		return $formattedDate;
	}
}